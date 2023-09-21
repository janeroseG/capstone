     <?php
         use PHPMailer\PHPMailer\PHPMailer;
         use PHPMailer\PHPMailer\SMTP;
         use PHPMailer\PHPMailer\Exception;

         require 'PHPMailer/src/Exception.php';
         require 'PHPMailer/src/PHPMailer.php';
         require 'PHPMailer/src/SMTP.php';

         $mail = new PHPMailer(true);
         $msg = "";

         if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $subject = $_POST['subject'];
            $message = $_POST['message'];

            try {
                $mail->isSMTP();                                         
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'harveyv291@gmail.com';                     //SMTP username
                $mail->Password   = 'sliasramziteymdc';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                
                 //Recipients
                $mail->setFrom('from@example.com', 'no reply');
                $mail->addAddress('harveyv291@gmail.com');     //Add a recipient
                $mail->addReplyTo($_POST['email'],$_POST['name']);

             //Content
         $mail->isHTML(true); 
         $mail->Subject = 'Form Submission: '.$_POST['subject'];                           //Set email format to HTML
         $mail->Body = "<h2>Name : $name <br>Email : $email <br>Message : $message</h2>";

         $mail->send();
         $msg = "<div class='alert alert-success'><h5>Thank You ! for contacting us, We'll get back to you soon.</h5></div>";
          } catch (Exception $e) {
            $msg = "<div class='alert alert-danger'><h5>'. $e->getMessage(). '</h5></div>";
          }
        }
     ?>    
      
     <div class="card-body px-4">
     <?php echo $msg; ?>
            <form action="#" method="POST" onsubmit="return namevalidate()" value="Validate Name">
              <div class="form-group">
              </div>
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name" required>
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email" required>
              </div>
              <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter Subject"
                  required>
              </div>
              <div class="form-group">
                <label for="message">Message</label>
                <textarea name="message" id="message" rows="5" class="form-control" placeholder="Write Your Message"
                  required></textarea>
              </div>
              <div class="form-group">
                <input type="submit" name="submit" value="Submit" class="btn btn-danger btn-block" id="sendBtn">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    function namevalidate(){

var regName = /^[a-zA-Z]+ [a-zA-Z]+ [a-zA-Z]+$/;

var name = document.getElementById('name').value;
if(!regName.test(name)){
    alert('Name should only accept letters and spaces.');
    document.getElementById('name').focus();
    return false;
}else{
    return true;
}
}
    </script>
</body>

</html>