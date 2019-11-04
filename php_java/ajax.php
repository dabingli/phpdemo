<html>
<head>
    <title>test</title>
    <script src="https://common.cnblogs.com/scripts/jquery-2.2.0.min.js"></script>
    <script type="text/javascript">
        // function callAPI() {
        //     $.ajax({
        //         type: "GET",
        //         url: "http://localhost:616/api/UserService/GetAll",
        //         dataType: "application/json;charset=utf-8",
        //         success: function (result) {
        //             alert(result);
        //         },
        //         error: function (e) {
        //             var test = e;
        //         }
        //     });
        // }
        function callAPIByJSONP() {
            var test = 1;
            $.ajax({
                type: "POST",
                async: false,
                url: "http://test.ds.api.aefzn.com/site/index",
                dataType: "json",
                jsonp: "callback",
                jsonpCallback:"handler",
                success: function (result) {
                	console.log(result);
                    // alert(result[0].UserName);
                },
                error: function (e) {
                    var test = e;
                }
            });
        }
    </script>
</head>
<body>
    <input type="button" value="普通调用" onclick="callAPI();" />
    <input type="button" value="JSONP调用" onclick="callAPIByJSONP();" />
</body>
</html>