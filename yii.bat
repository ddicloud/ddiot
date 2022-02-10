@REM @Author: Wang chunsheng  email:2192138785@qq.com
@REM @Date:   2021-11-29 18:15:46
@REM @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
@REM Modified time: 2021-12-10 21:46:57@echo off

rem -------------------------------------------------------------
rem  Yii command line bootstrap script for Windows.
rem -------------------------------------------------------------

@setlocal

set YII_PATH=%~dp0

if "%PHP_COMMAND%" == "" set PHP_COMMAND=php.exe

"%PHP_COMMAND%" "%YII_PATH%yii" %*

@endlocal
