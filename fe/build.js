#! /usr/bin/env node

var fs = require('fs');
var path = require('path');

var SRC_FILE_DIR = __dirname + path.sep + 'src' + path.sep;
var ASSET_FILE_DIR = __dirname + path.sep + 'asset' + path.sep;

var srcList = [];

var processArgs = process.argv.slice(2)[0];

if (processArgs) {
    processArgs = processArgs.replace(/^\-*/, '');
}

if (!fs.existsSync(ASSET_FILE_DIR)) {
    iMkdir(ASSET_FILE_DIR, 0);
}

function iMkdir (path, mode, fn) {
    var arr = path.split('/');
    mode = mode || 0755;
    fn = fn || function () {};

    // ./xxx
    if (arr[0] === '.') {
        arr.shift();
    }

    // ../xxx
    if (arr[0] === '..') {
        arr.splice(0, 2, arr[0] + '/' + arr[1]);
    }

    function _inner(curDir) {
        if (!fs.existsSync(curDir)) {
            if (curDir) {
                fs.mkdirSync(curDir, mode);
            }
        }
        if (arr.length) {
            _inner(curDir + '/' + arr.shift());
        }
        else{
            fn();
        }
    }
    arr.length && _inner(arr.shift());
}

function copyDir (dir) {
    fs.readdirSync(dir).sort(function(file) {
        var fullPath = path.resolve(dir, file);
        if (fs.statSync(fullPath).isDirectory()) {
            return 1;
        }
        return -1;
    }).forEach(function(file, index) {
        var fullPath = path.resolve(dir, file);
        var stat     = fs.statSync(fullPath);
        var extName  = path.extname(file);
        var name     = path.basename(file, extName);
        if (stat.isFile() && /^\.js$/i.test(extName)) {
            var pathStr = fullPath.replace(SRC_FILE_DIR, '');
            var pathArr = pathStr.split(path.sep);
            var tmp = [];
            pathArr.forEach(function (dir, index) {
                if (!/\.js$/.test(dir)) {
                    if (tmp.length > 0) {
                        iMkdir(
                            ASSET_FILE_DIR + tmp.join(path.sep) + path.sep + dir,
                            0
                        );
                    }
                    else {
                        iMkdir(ASSET_FILE_DIR + dir, 0);
                    }
                    tmp.push(dir);
                }
                else {
                    // console.log(SRC_FILE_DIR + pathStr);
                    // console.log(ASSET_FILE_DIR + pathStr);
                    uglify(
                        SRC_FILE_DIR + pathStr,
                        ASSET_FILE_DIR + pathStr
                    );
                }
            });
        }
        else if (stat.isDirectory()) {
            copyDir(fullPath);
        }
    });
}

function uglify(srcPath, jsMinPath) {
    var UglifyJS = require('uglify-js');
    try {
        var compressOptions = {};
        var basename = require('path').basename(srcPath);
        var origname = basename.replace('.js', '.org.js');
        fs.readFile(srcPath,'utf-8',function(err,data){
            if (err) {
                console.log("error");
            }
            else {
                var ast = UglifyJS.parse( data, { filename: origname } );
                var stream = UglifyJS.OutputStream( {
                    source_map: null
                });
                ast.figure_out_scope();
                ast = ast.transform( UglifyJS.Compressor( compressOptions ) );
                ast.figure_out_scope();
                ast.compute_char_frequency({
                    except: [ '$', 'require', 'exports', 'module' ]
                });
                ast.mangle_names({
                    except: [ '$', 'require', 'exports', 'module' ]
                });

                ast.print(stream);

                fs.writeFileSync(
                    jsMinPath,
                    stream.get(),
                    'UTF-8'
                );
            }
        });
        return;
    }
    catch ( ex ) {
        console.log(ex);
        return file.data;
    }
}


copyDir(SRC_FILE_DIR);


// require.config中baseUrl需要把src改为asset的文件
var fileList = [
    path.resolve(__dirname, '../application/views/header.php'),
    path.resolve(__dirname, '../application/views/home_new_1.php'),
    path.resolve(__dirname, '../application/views/home_new_2.php')
];

// var key = 'asset';
// var str = '<?php echo $js_domain;?>/fe/asset/';
// var reStr = '/(fe\\/)(\\b'+key+'\\b)/';
// var re = new RegExp(reStr, 'gi');
// str.replace(re, function () {
//     return RegExp.$1 + 'asset';
// });

// var replaceStr = '';
// var retStr = '';
// if (processArgs == 'src') {
//     replaceStr = 'asset';
//     retStr = 'src';
// }
// else {
//     replaceStr = 'src';
//     retStr = 'asset';
// }
// var reg = '/\(fe\\/\)(\\b'+replaceStr+'\\b)/gi';

fileList.forEach(function(file, index) {
    fs.readFile(file, 'utf8', function (err, data) {
        var reg = /(fe\/)(\bsrc\b)/;
        var newData = data.replace(reg, function () {
            return RegExp.$1 + 'asset';
        });
        // var newData = data.replace(reg, function () {
        //     return RegExp.$1 + retStr;
        // });

        fs.writeFile(file, newData, 'utf8', function(err){
            if (err) {
                console.log('写入文件失败');
            }
        });
    });
});