var express = require('express');
var path = require('path');
var app = express();
var fs = require('fs');
const cheerio = require('cheerio');

//cheerio.load(fs.readFileSync('/send_sms.html'));
// Set your app credentials
const credentials = {
    apiKey: '25c2a1dcd3eb62d1b02b0c5c7d765c80ccd9ad60d85b71cf446cba993247a94b',
    username: 'said',
}

// Initialize the SDK
const AfricasTalking = require('africastalking')(credentials);

app.get('/', function (req, res) {  
  const fp = res.sendFile(__dirname +'/send_sms.html');
  const content = fp.toString('utf8');
    const $ = cheerio.load(content);
    console.log($('body'));
});
app.use(express.static(path.join(__dirname, '/')));
app.listen(3000, function () {
  console.log('Example app listening on port 3000!');
});