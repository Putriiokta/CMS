<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <title>CMS</title>
        <meta content="" name="description">
        <meta content="" name="keywords">
        <link href="<?php echo $logo; ?>" rel="icon">
        <link href="<?php echo base_url(); ?>assets/front/img/apple-touch-icon.png" rel="apple-touch-icon">
        <link href="<?php echo base_url(); ?>assets/front/css/font.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/front/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/front/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/front/vendor/aos/aos.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/front/vendor/remixicon/remixicon.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/front/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/front/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/front/css/style.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/front/css/bootstrap.min.css" rel="stylesheet"/>
    </head>

    <body data-bs-spy="scroll" data-bs-target="#navbar" data-bs-offset="100">
        <header id="header" class="header fixed-top">
            <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
                <a href="<?php echo base_url(); ?>" class="logo d-flex align-items-center">
                    <img style="pointer-events: none;" src="<?php echo $logo; ?>" alt="" style="margin-top: -10px;">
                    <span>CMS</span>
                </a>
                <nav id="navbar" class="navbar">
                    <ul>
                        <li><a class="nav-link scrollto" href="#hero">Home</a></li>
                        <?php
                        if($this->nativesession->get('logged_in')){
                            ?>
                        <li><a class="getstarted" href="<?php echo base_url(); ?>login/logout">Log Out</a></li>
                            <?php
                        }else if($this->nativesession->get('logged_siswa')){
                            $ses = $this->nativesession->get('logged_siswa');
                            $nrp = $ses['nrp'];
                            ?>
                        <li><a class="getstarted" href="<?php echo base_url(); ?>login/logoutsiswa">Log Out : <?php echo $nrp; ?></a></li>
                            <?php
                        }else{
                            ?>
                        <li><a class="getstarted" href="<?php echo base_url(); ?>login">Log In</a></li>
                            <?php
                        }
                        ?>
                    </ul>
                    <i class="bi bi-list mobile-nav-toggle"></i>
                </nav>
            </div>
        </header>

        

        <main id="main">
            <!-- ======= Recent Blog Posts Section ======= -->
            <section style="margin-top 100px;" id="recent-blog-posts" class="recent-blog-posts">
                <div class="container" data-aos="fade-up">
                    <header class="section-header">
                        <p>Berita terbaru</p>
                    </header>
                    <div class="row">
                        <?php
                        foreach ($berita->result() as $row) {
                            ?>
                        <div class="col-lg-4">
                            <div class="post-box">
                                <div class="post-img">
                                    <?php
                                    $def = base_url().'assets/img/noimg.jpg';
                                    if(strlen($row->thumb) > 0){
                                        if(file_exists($row->thumb)){
                                            $def = base_url().substr($row->thumb, 2);
                                        }
                                    }
                                    ?>
                                    <img src="<?php echo $def; ?>" class="img-fluid" alt="">
                                </div>
                                <span class="post-date"><?php echo $row->tgl; ?></span>
                                <h3 class="post-title"><?php echo $row->judul ?></h3>
                                <a href="<?php echo base_url(); ?>blogsingle/index/<?php echo $this->modul->enkrip_url($row->idblog); ?>" class="readmore stretched-link mt-auto"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </section><!-- End Recent Blog Posts Section -->

            <!-- ======= Contact Section ======= -->
            <section id="contact" class="contact">
                <div class="container" data-aos="fade-up">
                    <header class="section-header">
                        <h2>Contact</h2>
                        <p>Contact Us</p>
                    </header>
                    <div class="row gy-4">
                        <div class="col-lg-6">
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <div class="info-box">
                                        <i class="bi bi-geo-alt"></i>
                                        <h3>Alamat</h3>
                                        <p><?php echo $alamat; ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-box">
                                        <i class="bi bi-telephone"></i>
                                        <h3>Telepon</h3>
                                        <p><?php echo $tlp; ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-box">
                                        <i class="bi bi-envelope"></i>
                                        <h3>Email</h3>
                                        <p><?php echo $email; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="php-email-form">
                                <div class="row gy-4">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Pengguna">
                                    </div>
                                    <div class="col-md-6 ">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email Pengguna">
                                    </div>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" id="judul" name="judul" placeholder="Judul">
                                    </div>
                                    <div class="col-md-12">
                                        <textarea class="form-control" id="pesan" name="pesan" rows="6" placeholder="Pesan"></textarea>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <div id="loading" class="loading" style="display: none;">Loading</div>
                                        <div id="pesan_error" class="error-message" style="display: none;">Error Pesan</div>
                                        <div id="pesan_sukses" class="sent-message" style="display: none;">Pesan terkirim. Terima Kasih!</div>
                                        <button id="btnKirimPesan" type="submit" onclick="kirimpesan();">Kirim Pesan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main><!-- End #main -->

        <!-- ======= Footer ======= -->
        <footer id="footer" class="footer">

            <div class="footer-top">
                <div class="container">
                    <div class="row gy-4">
                        <div class="col-lg-5 col-md-12 footer-info">
                            <a href="<?php echo base_url(); ?>welcome" class="logo d-flex align-items-center">
                                <img src="<?php echo $logo; ?>" alt="">
                                <span>CMS</span>
                            </a>
                            <p><?php echo $tentang; ?></p>
                            <div class="social-links mt-3">
                                <a href="<?php echo $tw; ?>" target="_blank" class="twitter"><i class="bi bi-twitter"></i></a>
                                <a href="<?php echo $fb; ?>" target="_blank" class="facebook"><i class="bi bi-facebook"></i></a>
                                <a href="<?php echo $ig; ?>" target="_blank" class="instagram"><i class="bi bi-instagram bx bxl-instagram"></i></a>
                                <a href="<?php echo $lk; ?>" target="_blank" class="linkedin"><i class="bi bi-linkedin bx bxl-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-2 col-6 footer-links">
                            
                        </div>
                        <div class="col-lg-2 col-6 footer-links">
                            
                        </div>
                        <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
                            <h4>Kontak Kami</h4>
                            <p>
                                <?php echo $alamat; ?><br><br>
                                <strong>Telepon :</strong> <?php echo $tlp; ?><br>
                                <strong>Email   :</strong> <?php echo $email; ?><br>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="copyright">
                    &copy; Copyright <strong><span><?php echo date('Y'); ?></span></strong>. All Rights Reserved
                </div>
                <div class="credits">
                    Created by @Dor pret
                </div>
            </div>
        </footer><!-- End Footer -->

        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

        <!-- Vendor JS Files -->
        <script src="<?php echo base_url(); ?>assets/js/jquery-3.5.1.js"></script>
        <script src="<?php echo base_url(); ?>assets/front/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/front/vendor/aos/aos.js"></script>
        <script src="<?php echo base_url(); ?>assets/front/vendor/php-email-form/validate.js"></script>
        <script src="<?php echo base_url(); ?>assets/front/vendor/swiper/swiper-bundle.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/front/vendor/purecounter/purecounter.js"></script>
        <script src="<?php echo base_url(); ?>assets/front/vendor/isotope-layout/isotope.pkgd.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/front/vendor/glightbox/js/glightbox.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/front/js/main.js"></script>
        
        <script>
            $(document).ready(function() {
                
            });
            
            function kirimpesan(){
                var nama = $('#nama').val();
                var email = $('#email').val();
                var judul = $('#judul').val();
                var pesan = $('#pesan').val();
                
                if(nama === ""){
                    $('#pesan_error').html("Nama harus diisi");
                    $('#pesan_error').show();
                }else if(email === ""){
                    $('#pesan_error').html("Email harus diisi");
                    $('#pesan_error').show();
                }else if(judul === ""){
                    $('#pesan_error').html("Judul harus diisi");
                    $('#pesan_error').show();
                }else if(pesan === ""){
                    $('#pesan_error').html("Pesan harus diisi");
                    $('#pesan_error').show();
                }else{
                    $('#pesan_error').html("");
                    $('#pesan_error').hide();
                    
                    $('#loading').show();
                    $('#btnKirimPesan').attr('disabled',true);

                    var form_data = new FormData();
                    form_data.append('nama', nama);
                    form_data.append('email', email);
                    form_data.append('judul', judul);
                    form_data.append('pesan', pesan);

                    $.ajax({
                        url: "<?php echo base_url(); ?>welcome/kirimpesan",
                        dataType: 'JSON',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        type: 'POST',
                        success: function (response) {
                            $('#loading').hide();
                            
                            $('#pesan_sukses').html(response.status);
                            $('#pesan_sukses').show();

                            $('#btnKirimPesan').attr('disabled',false);
                            
                            resetkomponen();

                        },error: function (response) {
                            $('#loading').hide();
                            
                            $('#pesan_error').html(response.status);
                            $('#pesan_error').show();
                            
                            $('#btnKirimPesan').attr('disabled',false);
                        }
                    });
                }
            }
            
            function resetkomponen(){
                $('#nama').val("");
                $('#email').val("");
                $('#judul').val("");
                $('#pesan').val("");
            }
            
            function showlistpenelitian(kode){
                window.location.href = "<?php echo base_url(); ?>listpenelitian/index/"+kode;
            }
            
        </script>

    </body>

</html>