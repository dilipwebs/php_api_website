<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
    /* Add a gray background color and some padding to the footer */
    footer {
      background-color: #f2f2f2;
      padding: 25px;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#">Portfolio</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Gallery</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      </ul>
    </div>
  </div>
</nav>
  
<div class="container">    
  
  <div class="col-md-8 col-sm-offset-2">
   
    <div class="panel">
    <div id="response"></div>
    <h2 class="text-center">Register here</h2>
        <form id="registerForm">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text"  name="name" class="form-control" id="name" autocomplete="true">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" id="email" autocomplete="true">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password">
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" class="form-control" id="phone" autocomplete="true">
            </div>
            <div class="form-group">
                <label for="city">City</label>
                <input type="text" name="city" class="form-control" id="city" autocomplete="true">
            </div>    
            <button type="submit" class="btn btn-default" id="registerBtn">Register Now</button>
        </form>
    </div>
  </div>
</div><br>

<footer class="container-fluid text-center">
  <p>Footer Text</p>
</footer>

<script>
    
    $.fn.formToJson = function () {
    form = $(this);

    var formArray = form.serializeArray();
    var jsonOutput = {};

    $.each(formArray, function (i, element) {
        var elemNameSplit = element['name'].split('[');
        var elemObjName = 'jsonOutput';

        $.each(elemNameSplit, function (nameKey, value) {
            if (nameKey != (elemNameSplit.length - 1)) {
                if (value.slice(value.length - 1) == ']') {
                    if (value === ']') {
                        elemObjName = elemObjName + '[' + Object.keys(eval(elemObjName)).length + ']';
                    } else {
                        elemObjName = elemObjName + '[' + value;
                    }
                } else {
                    elemObjName = elemObjName + '.' + value;
                }

                if (typeof eval(elemObjName) == 'undefined')
                    eval(elemObjName + ' = {};');
            } else {
                if (value.slice(value.length - 1) == ']') {
                    if (value === ']') {
                        eval(elemObjName + '[' + Object.keys(eval(elemObjName)).length + '] = \'' + element['value'].replace("'", "\\'") + '\';');
                    } else {
                        eval(elemObjName + '[' + value + ' = \'' + element['value'].replace("'", "\\'") + '\';');
                    }
                } else {
                    eval(elemObjName + '.' + value + ' = \'' + element['value'].replace("'", "\\'") + '\';');
                }
            }
        });
    });

    return jsonOutput;
}

$(document).ready(function(){
    
    $('#registerForm').submit(function(event) {
        event.preventDefault(); 
        var formData = JSON.stringify($("#registerForm").formToJson());
        
        var  url = 'http://localhost/core_php_api/register.php';
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: 'application/JSON',
            beforeSend: function(){
                $("#registerBtn").text("Submitting...");
            },
            success: function(result){

                $("#response").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Success!</strong> Your form has been submitted!</div>');
                $('#registerForm').find('input').val('');
                
            },
            error: function(){
                $("#response").html('<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Error!</strong>  </div>');
            },
            complete: function(){
                $("#registerBtn").text("Submit");
            }
        });

    });
});
   
</script>

</body>
</html>
