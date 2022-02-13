<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Example</title>
  <style>
    .a {
      background-color:red;
      height: 33px;
      display: flex;
      align-items: center;
      margin-bottom: 10px;
      cursor: pointer;
    }
    
    .b {
      background-color:#00AA00;
      height: 50px;
      display: flex;
      align-items: center;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <div class="a" data-el="1">1</div>
  <div class="b" data-el="no-click-handler">2</div>
  <div class="a" data-el="3">11</div>
</body>
</html>
</body>
<script>
const divs = document.querySelectorAll('.a');

divs.forEach(el => el.addEventListener('click', event => {
  console.log(event.target.getAttribute("data-el"));
}));
</script>
</html>