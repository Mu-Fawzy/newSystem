<!DOCTYPE html>
<html>
    <head>
        <title>نظام ادارة المستخلصات</title>
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="keywords" content="">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Stylesheets -->
        <link rel="stylesheet" href="css/bootstrap.min.css"/><!-- bootstrap grid -->
        <link rel="stylesheet" href="css/style.css"/><!-- bootstrap grid -->
        <link rel="stylesheet" href="css/responsive.css"/><!-- bootstrap grid -->
        <!--tables-->
        <link type="text/css" rel="stylesheet" href="css/jquery.dataTables.css" />
        <link type="text/css" rel="stylesheet" href="css/dataTables.colVis.css" />
        <link type="text/css" rel="stylesheet" href="css/dataTables.tableTools.css" />
    
        <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
		
    </head>
    <body>
    
        <div class="wrapper">
        <header>
        	<div class="header_top">
                <div class="container"> 
                    <div class="col-md-4 col-xs-4 right text-right">
                        <a class="login_button" id="show_login" href=""><i class="fa fa-sign-in"></i> تسجيل الدخول</a>
                    </div>
                    <div class="col-md-8 col-xs-8 left text-left">
                            <div class="social-media">
                        	<a href=""><i class="fa fa-facebook"></i></a>
                        	<a href=""><i class="fa fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        	<div class="header_bottom">
                <div class="container">
                	<div class="row">
                        <div class="col-md-12">
                           <div class="right logo text-center">
                                <img src="img/header1.jpg" alt="">
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </header>
        <!--end header-->
        <div class="content">
        	<div class="container">
            	<div class="row">
                	<div class="col-md-12">
                    	<div class="table-heading text-center">
                        	<h1>اعمال مصنعيات نجارة وحداده مبنى رقم 4</h1>
                        </div>
                    </div>
                </div>
                <div class="row">
                	<div class="col-md-6">
                    	<div class="invoice_info text-right">
                        	<p><span>المقاول :</span> مؤسسة مشاريع الاجيال</p>
                        	<p><span>التاريخ :</span> 13/1/2018</p>
                        </div>
                    </div>
                	<div class="col-md-6">
                    	<div class="invoice_info text-left">
                        	<p><span>المشروع :</span> مول الخالدى</p>
                        	<p><span>رقم المبنى :</span> 04</p>
                        	<p><span>رقم المستخلص :</span> 01</p>
                        </div>
                    </div>
                </div>
            	<div class="padding-top">
                	<div class="table-responsive">
                        <table id="example" class="table table-bordered">
                            <thead>
                              <tr>
                                <th rowspan="2">م</th>
                                <th rowspan="2">بيان الاعمال</th>
                                <th rowspan="2">الوحدة</th>
                                <th rowspan="2">الكمية</th>
                                <th rowspan="2">الفئة</th>
                                <th rowspan="2">إجمالى</th>
                                <th colspan="3">نسبة الإنجاز</th>
                                <th rowspan="2">إجمالى المستحق</th>
                                <th rowspan="2">ملاحظات</th>
                              </tr>
                              <tr>
                                <th>السابقة</th>
                                <th>الحالية</th>
                                <th>الإجمالية</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>1</td>
                                <td>دفعة بعد صب اعمدة الدور الاول</td>
                                <td>م2</td>
                                <td>2</td>
                                <td>25000</td>
                                <td>50000</td>
                                <td>20%</td>
                                <td>50%</td>
                                <td>70%</td>
                                <td>35000</td>
                                <td></td>
                              </tr>
                              <tr>
                                <td>2</td>
                                <td>دفعة بعد صب اعمدة الدور الاول</td>
                                <td>م2</td>
                                <td>2</td>
                                <td>25000</td>
                                <td>50000</td>
                                <td>20%</td>
                                <td>50%</td>
                                <td>70%</td>
                                <td>35000</td>
                                <td></td>
                              </tr>
                              <tr>
                                <td>3</td>
                                <td>دفعة بعد صب اعمدة الدور الاول</td>
                                <td>م2</td>
                                <td>2</td>
                                <td>25000</td>
                                <td>50000</td>
                                <td>20%</td>
                                <td>50%</td>
                                <td>70%</td>
                                <td>35000</td>
                                <td></td>
                              </tr>
                              <tr>
                                <td>4</td>
                                <td>دفعة بعد صب اعمدة الدور الاول</td>
                                <td>م2</td>
                                <td>2</td>
                                <td>25000</td>
                                <td>50000</td>
                                <td>20%</td>
                                <td>50%</td>
                                <td>70%</td>
                                <td>35000</td>
                                <td></td>
                              </tr>
                            </tbody>
                      </table>
                  	</div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <span class="note">* يراعى خصم ايجار فرم خشبية للأعمدة</span>
                    </div>
                    <div class="col-md-3">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                  <tr>
                                    <td>الإجمالى الكلى</td>
                                    <td>22500</td>
                                  </tr>
                                  <tr>
                                    <td>خصم ماسبق صرفة</td>
                                    <td>0</td>
                                  </tr>
                                  <tr class="green_color">
                                    <td>المستحق</td>
                                    <td>22500</td>
                                  </tr>
                                </tbody>
                          </table>
                        </div>
                    </div>
                </div>
                <div class="info_footer">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="invoice_info text-center">
                                <p><span>مهندس المشروع</span></p>
                                <br>
                                <p>م / محمد السيد</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="invoice_info text-center">
                                <p><span>الحسابات</span></p>
                                <br>
                                <p>أ / مدثر النور</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="invoice_info text-center">
                                <p><span>المدير التنفيذى</span></p>
                                <br>
                                <p>م / حسن تهامى</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="invoice_info text-center">
                                <p><span>المدير العام للمقاولات</span></p>
                                <br>
                                <p>م / احمد زكريا</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
      
    <script src="js/jquery-1.12.4.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <!--tables-->
		
    </body>
</html>