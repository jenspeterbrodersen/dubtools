function post() {
    // console.log("it works")
    var wuut = $.post('test.php', { example: "send from post" });
console.log(wuut)    
    $.post('test.php', { example: "send from post" });
    
    //     function (data) {
    //         $('#result').html(data);
    //         console.log(data)
    // });
}