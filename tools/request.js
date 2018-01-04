//#!phantomjs

var web_page = require("webpage");

var page = web_page.create();

/*
function process(status)
{
    console.log(status);
    phantom.exit();
}

page.open("http://localhost:8888", process(status));
*/

page.open("http://localhost:8888", function (status){
        console.log(status);
        if (status === "success")
        {
            page.render('example.png');
        }
        phantom.exit();}
);
