@REM @Author: Wang chunsheng  email:2192138785@qq.com
@REM @Date:   2020-10-27 14:35:56
@REM @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
@REM Modified time: 2021-04-24 17:05:51
@echo off

rem -------------------------------------------------------------
rem  Yii command line init script for Windows.
rem -------------------------------------------------------------

@setlocal

set YII_PATH=%~dp0

if "%PHP_COMMAND%" == "" set PHP_COMMAND=php.exe

"%PHP_COMMAND%" "%YII_PATH%init" %*

@endlocal
