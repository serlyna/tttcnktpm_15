<?php
    $connect = mysqli_connect('localhost','root','','book');
    $article = mysqli_fetch_array($connect->query("select * from article where id_article =" . $_GET['id_article']));
    if (isset($_POST['sua'])) {
        $name = $_POST['name'];
        $id_author = $_POST['id_author'];
        $id_product = $_POST['id_product'];
        $summary = $_POST['summary'];
        $content = $_POST['content'];
        $youtube = $_POST['youtube'];
            // $status = $_POST['status'];
            // Deal with upload images
            // destination to save images
            $store = "../../image/";
            $imageName = $_FILES['image']['name'];
        // save the temp path of file uploaded 
        $imageTemp = $_FILES['image']['tmp_name'];
        // take the expand of file
        $exp3 = substr($imageName, strlen($imageName) - 3); #abcd.jpg;
        $exp4 = substr($imageName, strlen($imageName) - 4); #abcd.jpeg;

            if (
                $exp3 == 'jpg' || $exp3 == 'png' || $exp3 == 'bmp' || $exp3 == 'gif' || $exp4 == 'webp' || $exp4 == 'jpeg' ||
                $exp3 == 'JPG' || $exp3 == 'PNG' || $exp3 == 'GIF' || $exp3 == 'BMP' || $exp4 == 'WEBP' || $exp4 == 'JPEG'
            ) {
                // change the name of image, difference 1/1/1970 -> now (ms)
                $imageName = time() . '_' . $imageName;
                // move file upload to the destination want to save
                move_uploaded_file($imageTemp, $store . $imageName);
                // if ("../images" . $product['image']) unlink("../images" . $product['image']);
                // delete the old image after update new image to save the memory
                unlink($store.$article['image']);
            } 
            else {
                $alert = "File đã chọn không hợp lệ";
            }
            if (empty($imageName)) {
                //if admin don't change the image it will be the old
                $imageName = $article['image'];
               
            }
            $query = "update article set id_author = $id_author, id_product = $id_product, name = '$name',
           summary = '$summary', content = '$content', image = '$imageName', youtube='$youtube'
            
            where id_article = " . $_GET['id_article'] ;
            $kq = mysqli_query($connect , $query);
            header("Location:table-data-article.php");
        }
    
?>
<?php
$author = $connect->query("select * from author");
$product = $connect->query("select * from product");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Sửa thông tin sản phẩm </title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <!-- Font-icon css-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
  <!-- or -->
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
  <link rel="stylesheet" type="text/css"
    href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
  <script src="http://code.jquery.com/jquery.min.js" type="text/javascript"></script>
</head>

<body class="app sidebar-mini rtl">
  <style>
    .Choicefile {
      display: block;
      background: #14142B;
      border: 1px solid #fff;
      color: #fff;
      width: 150px;
      text-align: center;
      text-decoration: none;
      cursor: pointer;
      padding: 5px 0px;
      border-radius: 5px;
      font-weight: 500;
      align-items: center;
      justify-content: center;
    }

    .Choicefile:hover {
      text-decoration: none;
      color: white;
    }

    #uploadfile,
    .removeimg {
      display: none;
    }

    #thumbbox {
      position: relative;
      width: 100%;
      margin-bottom: 20px;
    }

    .removeimg {
      height: 25px;
      position: absolute;
      background-repeat: no-repeat;
      top: 5px;
      left: 5px;
      background-size: 25px;
      width: 25px;
      /* border: 3px solid red; */
      border-radius: 50%;

    }

    .removeimg::before {
      -webkit-box-sizing: border-box;
      box-sizing: border-box;
      content: '';
      border: 1px solid red;
      background: red;
      text-align: center;
      display: block;
      margin-top: 11px;
      transform: rotate(45deg);
    }

    .removeimg::after {
      /* color: #FFF; */
      /* background-color: #DC403B; */
      content: '';
      background: red;
      border: 1px solid red;
      text-align: center;
      display: block;
      transform: rotate(-45deg);
      margin-top: -2px;
    }
  </style>
  <!-- Navbar-->
  <header class="app-header">
    <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar"
      aria-label="Hide Sidebar"></a>
    <!-- Navbar Right Menu-->
    <ul class="app-nav">


      <!-- User Menu-->
      <li><a class="app-nav__item" href="/index.php"><i class='bx bx-log-out bx-rotate-180'></i> </a>

      </li>
    </ul>
  </header>
  <!-- Sidebar menu-->
  <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
  <aside class="app-sidebar">
    <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="/images/hay.jpg" width="50px"
        alt="User Image">
      <div>
        <p class="app-sidebar__user-name"><b>Admin</b></p>
        <p class="app-sidebar__user-designation">Chào mừng bạn trở lại</p>
      </div>
    </div>
    <hr>
    <ul class="app-menu">
      <li><a class="app-menu__item haha" href="phan-mem-ban-hang.php"><i class='app-menu__icon bx bx-cart-alt'></i>
          <span class="app-menu__label">POS Bán Hàng</span></a></li>
      <li><a class="app-menu__item " href="index.php"><i class='app-menu__icon bx bx-tachometer'></i><span
            class="app-menu__label">Bảng điều khiển</span></a></li>
      <li><a class="app-menu__item " href="table-data-table.php"><i class='app-menu__icon bx bx-id-card'></i>
          <span class="app-menu__label">Quản lý nhân viên</span></a></li>
          <li><a class="app-menu__item " href="table-data-author.php"><i class='app-menu__icon bx bx-id-card'></i> <span
            class="app-menu__label">Quản lý tác giả</span></a></li>
            <li><a class="app-menu__item" href="table-data-customer.php"><i class='app-menu__icon bx bx-user-voice'></i><span
            class="app-menu__label">Quản lý khách hàng</span></a></li>
      <li><a class="app-menu__item " href="table-data-product.php"><i
            class='app-menu__icon bx bx-purchase-tag-alt'></i><span class="app-menu__label">Quản lý sách</span></a>
      </li>
      <li><a class="app-menu__item" href="table-data-oder.php"><i class='app-menu__icon bx bx-task'></i><span
            class="app-menu__label">Quản lý đơn hàng</span></a></li>
            <li><a class="app-menu__item active" href="table-data-article.php"><i class='app-menu__icon bx bx-run'></i><span
            class="app-menu__label">Quản lý bài viết
          </span></a></li>
      <li><a class="app-menu__item" href="table-data-money.php"><i class='app-menu__icon bx bx-dollar'></i><span
            class="app-menu__label">Bảng kê lương</span></a></li>
      <li><a class="app-menu__item" href="quan-ly-bao-cao.php"><i
            class='app-menu__icon bx bx-pie-chart-alt-2'></i><span class="app-menu__label">Báo cáo doanh thu</span></a>
      </li>
      <li><a class="app-menu__item" href="page-calendar.php"><i class='app-menu__icon bx bx-calendar-check'></i><span
            class="app-menu__label">Lịch công tác </span></a></li>
      <li><a class="app-menu__item" href="#"><i class='app-menu__icon bx bx-cog'></i><span class="app-menu__label">Cài
            đặt hệ thống</span></a></li>
    </ul>
  </aside>
  <main class="app-content">
    <div class="app-title">
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item">Danh sách bài viết</li>
        <li class="breadcrumb-item"><a href="#">Sửa nội dung bài viết</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title">Sửa nội dung bài viết</h3>
          <div class="tile-body">
            <div class="row element-button">
              <div class="col-sm-2">
                <a class="btn btn-add btn-sm" data-toggle="modal" data-target="#exampleModalCenter"><i
                    class="fas fa-folder-plus"></i> Thêm tác giả</a>
              </div>
              <div class="col-sm-2">
                <a class="btn btn-add btn-sm" data-toggle="modal" data-target="#adddanhmuc"><i
                    class="fas fa-folder-plus"></i> Thêm thể loại</a>
              </div>
              <div class="col-sm-2">
                <a class="btn btn-add btn-sm" data-toggle="modal" data-target="#addtinhtrang"><i
                    class="fas fa-folder-plus"></i> Thêm nhà cung cấp</a>
              </div>
            </div>
            <form class="row" method="post" enctype="multipart/form-data">
              
              <div class="form-group col-md-6">
                <label class="control-label">Tên bài viết</label>
                <input class="form-control" type="text" name="name" value="<?php echo $article['name']?>">
              </div>
              <div class="form-group col-md-3 ">
                <label for="exampleSelect1" class="control-label">Tác giả</label>
                <select class="form-control" id="exampleSelect1" name="id_author">
                  <option>-- Chọn tác giả --</option>
                  <?php foreach ($author as $item) : ?>
                <option value="<?= $item['id_author'] ?>" <?= $item['id_author'] == $article['id_author'] ? 'selected' : '' ?>>
                    <?= $item['name'] ?>
                </option>
            <?php endforeach; ?>
                
                </select>
              </div>
              <div class="form-group col-md-3">
                <label for="exampleSelect1" class="control-label">Tên sách</label>
                <select class="form-control" id="exampleSelect1" name="id_product">
                  <option>-- Chọn tên sách --</option>
                  <?php foreach ($product as $item) : ?>
                <option value="<?= $item['id_product'] ?>" <?= $item['id_product'] == $article['id_article'] ? 'selected' : '' ?>>
                    <?= $item['name'] ?>
                </option>
                <?php endforeach; ?>
                </select>
              </div>
              
              <div class="form-group col-md-9">
              <textarea class="form-control" name="summary" id="summary" ><?php echo $article['summary']?></textarea>
                <script>CKEDITOR.replace('summary');</script>
              </div>
              <div class="form-group col-md-12">
                <label class="control-label">Nội dung</label>
                <textarea class="form-control" name="content" id="content" ><?php echo $article['content']?></textarea>
                <script>CKEDITOR.replace('content');</script>
              </div>
              <div class="form-group col-md-6">
                <label class="control-label">Ảnh bài viết</label>
                  <input type="file"  name="image"  />
                  <br>
                  <img src="../../image/<?=$article['image']?>" alt="" width="100" height="100" >
              </div>
              <div class="form-group col-md-6">
                <label class="control-label">Youtube</label>
                  <input type="text"  name="youtube"  value="<?php echo $article['youtube']?>"/>
              </div>
          </div>

          <input class="btn btn-save" type="submit" name="sua" value="Lưu lại"></input>
          <a class="btn btn-cancel" href="table-data-article.php">Hủy bỏ</a>
        </div>
                  </form>
  </main>





 



  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
  <script src="js/plugins/pace.min.js"></script>
  <script>
    const inpFile = document.getElementById("inpFile");
    const loadFile = document.getElementById("loadFile");
    const previewContainer = document.getElementById("imagePreview");
    const previewContainer = document.getElementById("imagePreview");
    const previewImage = previewContainer.querySelector(".image-preview__image");
    const previewDefaultText = previewContainer.querySelector(".image-preview__default-text");
    inpFile.addEventListener("change", function () {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        previewDefaultText.style.display = "none";
        previewImage.style.display = "block";
        reader.addEventListener("load", function () {
          previewImage.setAttribute("src", this.result);
        });
        reader.readAsDataURL(file);
      }
    });

  </script>
</body>

</html>