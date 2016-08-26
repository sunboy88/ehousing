SET CYGWIN_PATH=D:\prog\GnuWin32\bin

for %%I in (*.php) do (%CYGWIN_PATH%\cat.exe linesToAdd.txt >> %%I)