mkdir -p projecttmp/require
cd projecttmp/require
curl -sL https://github.com/pctronique/pctrouting/archive/refs/tags/1.0.0.tar.gz | tar xz
cp -r pctrouting-1.0.0/project/www/src/class/pctrouting ../../project/www/src/class/
cd ../..
rm -rf projecttmp/require
