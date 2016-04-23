var arr = [];
for(i=0;i<10;i++)
arr.push(i);

arr.toString();
var http = require('http');
var fs = require('fs');
var server = http.createServer(function(req,res)
{
 res.writeHead(200,{'content-type':'text/plain'});
 

fs.writeFile('less2.txt',arr.toString(), 'utf8', function (err,data) {
  if (err) {
    return console.log(err);
  }
  console.log(data);
  res.end('written');
});
}).listen(1990,'127.0.0.1');

