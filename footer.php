<div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-3 col-md-6">
                <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Company</h4>
                <a class="btn btn-link" href="">About Us</a>
                <a class="btn btn-link" href="">Contact Us</a>
                <a class="btn btn-link" href="">Reservation</a>
                <a class="btn btn-link" href="">Privacy Policy</a>
                <a class="btn btn-link" href="">Terms & Condition</a>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Contact</h4>
                <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@example.com</p>
                <div class="d-flex pt-2">
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Opening</h4>
                <h5 class="text-light fw-normal">Monday - Saturday</h5>
                <p>09AM - 09PM</p>
                <h5 class="text-light fw-normal">Sunday</h5>
                <p>10AM - 08PM</p>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Feed Back</h4>
                <p>Give your Personal Reviews</p>
                <div class="position-relative mx-auto" style="max-width: 400px;">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reviews">
                        Get Started
                    </button>
                </div>
            </div>
        </div>


        <!--Reviews Modal -->
        <?php if(isset($_SESSION['name'])) :?>
            <div class="modal fade" id="reviews" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog ">
                    <div class="modal-content ">
                        <div class="modal-body d-flex justify-content-center ">
                            <form action="reviews.php" method="post" enctype="multipart/form-data">
                                <h4 class='text-warning'>Hi! <?php echo $_SESSION['name'] ; ?></h4>
                                <label for="profession" class="form-label  text-secondary">profession</label><br>
                                <input type="text" name='profession' class="form-control" required><br>
                                <label for="image" class="form-label text-secondary">Select Image:</label><br>
                                <input type="file" name="image" class="form-control" required><br>
                                <label for="message" class="form-label text-secondary">Message</label><br>
                                <textarea type="text" name='message' class="form-control"
                                    placeholder='Express your thoughts about our Services or products' required></textarea><br><br>
                                <div class="modal-footer justify-content-center ">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary" name="submit">Send Message</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php else :?>
            <!-- Modal -->
            <div class="modal fade" id="reviews" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content ">
                        <div class="modal-header d-flex justify-content-center">
                            <h4 class="modal-title text-warning">Sorry &#128522; </h4>
                        </div>
                        <div class="modal-body ">
                            <h6 class='text-warning'>Login is required </h6>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <a type="button"  class="btn btn-warning text-light" href='login.php'>Login</a>
                        </div>
                    </div>
                </div>
            </div>   
        <?php endif;?> 
    
    </div>
</div>

