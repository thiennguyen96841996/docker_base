if [ ! -d /usr/src/app/node_modules ]; then
    mkdir /usr/src/app/node_modules
fi
if [ -z "$(ls -A /usr/src/app/node_modules)" ]; then
    npm install && npm run watch
else
    npm run watch
fi
