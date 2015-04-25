<div class="container">
    <header>
        <h2>Contact</h2>
        <div class="container">
            <form id="contactForm" method="post" action="main_page.php" >

                <div class="form-group">
                    <label for="message" class="col-md-2 control-label">Message</label>
                    <div class="col-md-10">
                        <textarea id="commentInput" name="commentInput" class="form-control" rows="8"></textarea>

                        <span class="pull-left">Please rate your experience with Healthy Tasks</span>
                        <span class="pull-left" id="starRating"><input id="input-21b" name="starInput" value="0" type="number" class="rating" min=0 max=5 step=0.1 data-size="xs"></span>
                        <script>
                            $('#input-21b').on('rating.change', function (event, value) {
                                //$('#input-21b').html(value);

                            });
                        </script>
                    </div>

                </div>


                <div class="form-group">     

                    <div class="col-md-10 col-md-offset-2">
                        <input type="submit" id="sendContact" name="sendContact" class="btn btn-success btn-lg pull-left"  value="Send" onclick="fakeLoaderFunction(5000);">
                        <input type="reset" name="cancelContact"  class="btn btn-danger btn-lg pull-left" value="Cancel">

                    </div>
                    <?php
                    require_once 'php_functions/main_page_functions.php';
                    if (isset($_POST['sendContact'])) {
                        $contactText = $_POST['commentInput'];
                        $starInput = $_POST['starInput'];
                        sendContact($contactText, $starInput);
                    }
                    ?>

                </div>

            </form>

        </div>
    </header>

</div>

