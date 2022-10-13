<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-09-20 20:30:28
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-13 15:21:36
 */

declare(strict_types=1);

namespace ddswoole\process;

use Swoole\Constant;
use function Swoole\Coroutine\run;
use Swoole\Process\Pool;
use yii\base\Component;

class Manager extends Component
{
    /**
     * @var Pool
     */
    protected $pool;

    /**
     * 监听列表.
     *
     * @var array
     * @date 2022-10-13
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    protected $_listens;

    /**
     * @var int
     *          SWOOLE_IPC_NONE 默认为 0 表示不使用任何进程间通信特性】
     *          设置为 0 时必须设置 onWorkerStart 回调，并且必须在 onWorkerStart 中实现循环逻辑，当 onWorkerStart 函数退出时工作进程会立即退出，之后会由 Manager 进程重新拉起进程；
     *          - 设置为 SWOOLE_IPC_MSGQUEUE 表示使用系统消息队列通信，可设置 $msgqueue_key 指定消息队列的 KEY，未设置消息队列 KEY，将申请私有队列；
     *          - 设置为 SWOOLE_IPC_SOCKET 表示使用 Socket 进行通信，需要使用 listen 方法指定监听的地址和端口；
     *          - 设置为 SWOOLE_IPC_UNIXSOCK 表示使用 unixSocket 进行通信，协程模式下使用，强烈推荐用此种方式进程间通讯，具体用法见下文；
     *          - 使用非 0 设置时，必须设置 onMessage 回调，onWorkerStart 变更为可选。
     */
    protected $ipcType = SWOOLE_IPC_NONE;

    /**
     * @var int
     */
    protected $msgQueueKey = 0;

    /**
     * @var array
     */
    protected $startFuncMap = [];

    /**
     * @var array
     */
    protected $stopFuncMap = [];

    /**
     * @var array
     */
    protected $messageFuncMap = [];

    public function __construct(int $ipcType = SWOOLE_IPC_NONE, array $listens = [], int $msgQueueKey = 0)
    {
        $this->_listens = $listens;
        $this->setIPCType($ipcType)->setMsgQueueKey($msgQueueKey);
        parent::__construct();
    }

    public function start()
    {
        $this->createPool();
        $this->onWorkerStart();
        $this->onWorkerStop();
        $this->onMessage();
        $this->listens();
        $this->pool->start();
    }

    public function createPool()
    {
        $this->pool = new Pool(count($this->startFuncMap), $this->ipcType, $this->msgQueueKey, false);
    }

    public function onWorkerStart(): void
    {
        $this->pool->on(Constant::EVENT_WORKER_START, function (Pool $pool, int $workerId) {
            [$func, $enableCoroutine] = $this->startFuncMap[$workerId];
            if ($enableCoroutine) {
                run($func, $pool, $workerId);
            } else {
                $func($pool, $workerId);
            }
        });
    }

    public function onWrite(string $data)
    {
        $this->pool->write($data);
    }

    public function onWorkerStop()
    {
        $this->pool->on(Constant::EVENT_WORKER_STOP, function (Pool $pool, int $workerId) {
            [$func, $enableCoroutine] = $this->stopFuncMap[$workerId];
            if ($enableCoroutine) {
                run($func, $pool, $workerId);
            } else {
                $func($pool, $workerId);
            }
        });
    }

    public function onMessage()
    {
        // 使用非 0 设置时，必须设置 onMessage 回调，onWorkerStart 变更为可选。
        if ($this->ipcType > 0) {
            $this->pool->on(Constant::EVENT_MESSAGE, function (Pool $pool, string $data) {
                echo 'onMessage:'.$data;
                // [$func, $enableCoroutine] = $this->messageFuncMap[$workerId];
                // if ($enableCoroutine) {
                //     run($func, $pool, $workerId);
                // } else {
                //     $func($pool, $workerId);
                // }
            });
        }
    }

    public function listens()
    {
        $listens = $this->_listens;
        if ($this->ipcType === SWOOLE_IPC_SOCKET) {
            foreach ($listens as $key => $value) {
                $host = $value['host'] ?? '127.0.0.1';
                $port = $value['port'] ?? 0;
                $backlog = $value['backlog'] ?? 2048;
                $this->listen($host, $port, $backlog);
            }
        }
    }

    public function listen(string $host, int $port = 0, int $backlog = 2048): bool
    {
        if ($this->ipcType === SWOOLE_IPC_SOCKET) {
            return  $this->pool->listen($host, $port);
        }
    }

    public function detach(): bool
    {
        return  $this->pool->detach();
    }

    public function stop(): void
    {
    }

    public function shutdown(): bool
    {
        return $this->pool->shutdown();
    }

    public function add(callable $func, $event = 'start', bool $enableCoroutine = false): self
    {
        $this->addBatch(1, $func, $event, $enableCoroutine);

        return $this;
    }

    public function addBatch(int $workerNum, callable $func, $event, bool $enableCoroutine = false): self
    {
        switch ($event) {
            case 'start':
                for ($i = 0; $i < $workerNum; ++$i) {
                    $this->startFuncMap[] = [$func, $enableCoroutine];
                }
                break;
            case 'stop':
                for ($i = 0; $i < $workerNum; ++$i) {
                    $this->stopFuncMap[] = [$func, $enableCoroutine];
                }
                break;
            case 'message':
                for ($i = 0; $i < $workerNum; ++$i) {
                    $this->messageFuncMap[] = [$func, $enableCoroutine];
                }
                break;

            default:
                for ($i = 0; $i < $workerNum; ++$i) {
                    $this->startFuncMap[] = [$func, $enableCoroutine];
                }
                break;
        }

        return $this;
    }

    public function setIPCType(int $ipcType): self
    {
        $this->ipcType = $ipcType;

        return $this;
    }

    public function getIPCType(): int
    {
        return $this->ipcType;
    }

    public function setMsgQueueKey(int $msgQueueKey): self
    {
        $this->msgQueueKey = $msgQueueKey;

        return $this;
    }

    public function getMsgQueueKey(): int
    {
        return $this->msgQueueKey;
    }
}
