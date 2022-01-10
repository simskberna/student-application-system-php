<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=
  , initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <title>Yatay Gecis Basvurulari</title>
</head>
<body>
 
    @csrf
    <input type="text" hidden value="YatayGecisBasvurusu" name="basvuruTip">
    <?php
    if (isset($data)){
        foreach ($data as $key) {
            ?>
            <div class="header_item">
                <h4><?php echo($key['value']);?></h4>
            </div>
            <?php
        }
    }
    ?>
    <style>
      body{
        padding-left: 10%;
        float: left;
        background-color: #5eb5d7;
      }
      .fancy {
          font-family: cursive;
          color: #000000;
      }
      a.fancy, a.fancy:visited, a.fancy:link{
        color: rgb(255, 255, 255) !important; 
      }
    </style>

   
</body>
</html>