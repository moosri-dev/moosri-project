<?php
	// $pathRoot = $_SERVER["DOCUMENT_ROOT"];
	include(__DIR__."/src/config/config.php");
	include ($DOCUMENT_ROOT."/moosri-project/src/config/connect-db.php");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include __DIR__ . '/src/assets/scripts/script.html'; ?>

		<link rel="stylesheet" type="text/css" href="/moosi-massage/src/assets/css/style.css">
	</head>
	<body>
		<!-- header -->
		<?php include __DIR__ . '/src/components/header.html'; ?>
		<!-- /.header -->

		<!-- container -->
		<div class="container margin-top-80">
	      <!-- Heading Row -->
	      <div class="row my-4">
	        <div class="col-lg-8">

				<div id="carouselItemControls" class="carousel slide" data-ride="carousel">

				  <div class="carousel-inner">
				    <div class="carousel-item active">
				      <img class="img-fluid rounded" src="src/assets/images/spa-slide1.jpg">
				    </div>
				    <div class="carousel-item">
				      <img class="img-fluid rounded" src="src/assets/images/spa-slide2.jpg">
				    </div>
				    <div class="carousel-item">
				      <img class="img-fluid rounded" src="src/assets/images/spa-slide3.jpg">
				    </div>
				  </div>
				  <a class="carousel-control-prev" href="#carouselItemControls" role="button" data-slide="prev">
				    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
				    <span class="sr-only">Previous</span>
				  </a>
				  <a class="carousel-control-next" href="#carouselItemControls" role="button" data-slide="next">
				    <span class="carousel-control-next-icon" aria-hidden="true"></span>
				    <span class="sr-only">Next</span>
				  </a>

				  <ol class="carousel-indicators">
					    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
					    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
					    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
				 	 </ol>

				</div>
	        </div>
	        <!-- /.col-lg-8 -->
	        <div class="col-lg-4">
	          		<h3>หมู่ 4 นวดแผนไทย</h3>
	          		<p>การนวดที่เป็นเอกลักษณ์ของเราพร้อมด้วยเทคนิคหลากหลายที่ได้รับแรงบันดาลใจจากการนวดแบบเอเชียที่เป็นที่นิยม เหมาะสำหรับบรรเทาความตึงเครียดตึงและปวดเมื่อยตามร่างกาย</p>
	        </div>
	        <!-- /.col-md-4 -->
	      </div>
	      <!-- /.row -->
	      <div class="card text-white bg-brown my-4 text-center">
	        <div class="card-body">
	          <p class="text-white m-0">บริการนวดแผนไทย</p>
	        </div>
	      </div>
	      <!-- Content Row -->
	      <div class="row">
	      	<?php for($i = 0;$i<3;$i++){?>
	        <div class="col-md-4 mb-4">
	          <div class="card h-100">
	          	<img class="card-img-top img-height-150" src="src/assets/images/thai-massage1.jpg">
	            <div class="card-body my-card">
	              <h4 class="card-title">นวดออยล์ อโรมา</h4>
	              <p class="card-text">การนวดน้ำมันอโรมาที่สดชื่นจากน้ำมันหอมระเหยที่จะทำให้คุณรู้สึกผ่อนคลายเพื่อเริ่มต้นและสิ้นสุดวันใหม่ของคุณ
	              </p>
	              <div class="icon">
	              	<i class="far fa-clock"></i>
	              	60 นาที 400 บาท
	              </div>
	            </div>
	            <div class="card-footer text-center">
	              <a href="#" class="btn btn-outline-primary btn-padding">จอง</a>
	            </div>
	          </div>
	        </div>

	        <!-- /.col-md-4 -->
	        <div class="col-md-4 mb-4">
	          <div class="card h-100">
	          	<img class="card-img-top img-height-150" src="src/assets/images/foot-massage1.jpg">
	            <div class="card-body my-card">
	              <h4 class="card-title">นวดเท้า</h4>
	              <p class="card-text">
	              	การผสมผสานระหว่างการนวดเท้าแบบไทยและเทคนิคการนวดกดจุดแบบจีนทั่วไปเพื่อคลายความเมื่อยล้าของเท้าและขา ช่วยส่งเสริมการเติมออกซิเจนของเนื้อเยื่อปรับปรุงการไหลเวียนโลหิตบรรเทาอาการปวดและรักษาความเจ็บป่วยเฉียบพลันและเรื้อรังที่หลากหลาย
	              </p>
	              <div class="icon">
	              	<i class="far fa-clock"></i>
	              	30 นาที 250 บาท
	              </div>
	            </div>
	            <div class="card-footer text-center ">
	              <a href="#" class="btn btn-outline-primary btn-padding">จอง</a>
	            </div>
	          </div>
	        </div>
	        <!-- /.col-md-4 -->
	        <div class="col-md-4 mb-4">
	          <div class="card h-100">
	          	<img class="card-img-top img-height-150" src="src/assets/images/thai-massage4.jpg">
	            <div class="card-body my-card">
	              <h4 class="card-title">นวดแผนไทย</h4>
	              <p class="card-text">
	              	การนวดแผนไทยโบราณเพื่อผ่อนคลายกล้ามเนื้อของคุณและเพิ่มการไหลของพลังงาน
	              </p>
	              <div class="icon">
	              	<i class="far fa-clock"></i>
	              	90 นาที 600 บาท
	              </div>
	            </div>
	            <div class="card-footer text-center">
	              <a href="#" class="btn btn-outline-primary btn-padding">จอง</a>
	            </div>
	          </div>
	        </div>
	        <!-- /.col-md-4 -->
	       <?php }?>
	      </div>
	      <!-- /.row -->
	    </div>
	    <!-- /.container -->

	    <!-- footer -->
	    <?php include __DIR__ . '/src/components/footer.html'; ?>
	    <!-- /.footer -->
	</body>
</html>

