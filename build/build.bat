start /w node r.js -o app.build.js
cd ..\dist
rmdir /Q /S build
copy main.js ..\public\scripts\main.min.js
copy vendor\requirejs\require.js ..\public\scripts\vendor\requirejs\require.min.js
copy require-jquery.js ..\public\scripts\require-jquery.min.js
cd ..\build