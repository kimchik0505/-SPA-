<?php
session_start();

$mysqli = new mysqli("localhost", "root", "", "web_prog");
if ($mysqli->connect_errno) {
    printf("Соединение не удалось: %s\n", $mysqli->connect_error);
    exit();
}
$query = "SELECT * FROM users ORDER by ID";
if ($result = $mysqli->query($query)) {
	$array = array ();
    while ($row = $result->fetch_assoc()) {
        	$array[]=$row;
    }

    $result->free();
}

$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>transport.s</title>
	<link rel="stylesheet" href="css/main.css">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
		<script type="text/javascript">
 $(document).ready(function(){
    $("#menu").on("click","a", function (event) {
        event.preventDefault();
        var id  = $(this).attr('href'),
            top = $(id).offset().top;
        $('body,html').animate({scrollTop: top}, 1500);
    });
});
</script>
</head>
<body>

	<header>
		<div class="container" id = "home">
			<div class="heading clearfix">
				
				<nav id = "menu">
					<ul class="menu">
						<li>
							<a href="#home">Главная</a>
						</li>
						<li>
							<a href="#uslugi">Услуги</a>
						</li>
						<li>
							<a href="#orderf">Заказ перевозки</a>
						</li>
						<li>
							<a href="#">О нас</a>
						</li>
						<li>
							<a href="#">Контакты</a>
						</li>
					</ul>
				</nav>
			</div>
			<div class="titles">
				<div class="titles__first">
					Добро пожаловать!
				</div>
				<h1>
					Рады видеть вас <br />
					<?php
					if(isset($_SESSION['email']) && isset($_SESSION['password'])){
					for($i=0;$i<count($array);$i++){	
						if($_SESSION['email']==$array[$i]['email'])
						{
							$_SESSION['first_name'] = $array[$i]['first_name'];
						}						
					}
						echo '<div class = "name">'.$_SESSION['first_name'].'!</div>';			
						}		
					?>
					</h1>				
			</div>
			<?php
			if(!isset($_SESSION['email']) && !isset($_SESSION['password'])){
			?>
		<form action = "/form_register.php">
			<input type="submit" class="inline" value="Регистрация">
		</form>
		<form action = "/form_auth.php">
			<input type="submit" class="inline" value="Авторизация">
		</form>
		<?php
	}
	else{
		?>
		<form action = "/logout.php">
			<input type="submit" class="inline" value="Выход">
		</form>
	<?php
	}
	?>
		</div>

		</div>
	</header>


	<section id="services">
		<div class="container" id = "uslugi">
			<div class="title">
				<h2>
					Наши услуги
				</h2>
				<p>
					Что мы можем.
				</p>
			</div>
			<div class="services clearfix">
				<div class="services__item">
					<img src="img/icon1.png" alt="Услуга">
					<h3>Доставка</h3>
					<p>
						Proin iaculis purus consequat sem cure digni ssim. Donec porttitora entum suscipit 
						aenean rhoncus posuere odio in tincidunt.
					</p>
				</div>
				<div class="services__item">
					<img src="img/icon2.png" alt="Услуга">
					<h3>Транспортировка</h3>
					<p>
						Proin iaculis purus consequat sem cure digni ssim. Donec porttitora entum suscipit 
						aenean rhoncus posuere odio in tincidunt.
					</p>
				</div>
				<div class="services__item">
					<img src="img/icon3.png" alt="Услуга">
					<h3>Переезд</h3>
					<p>
						Proin iaculis purus consequat sem cure digni ssim. Donec porttitora entum suscipit 
						aenean rhoncus posuere odio in tincidunt.
					</p>
				</div>
			</div>
		</div>
	</section>
	<section id="order">
		<div class="contack_form" id = "orderf">			
				<h2>Оформление заказа</h2>
				<form action="form_order.php" name="orderform" method="post">					
    <?php
    $autoname = '';
    $autoemail = '';
        if(isset($_SESSION['email']) && isset($_SESSION['password'])){
        	$autoname = $_SESSION['first_name'];
        	$autoemail = $_SESSION['email'];
        }
        echo '
					<table>
						<tbody>
						<tr>
							<td>Ваше имя<span class="red">*</span></td>
							<td>
								<input type="text" name="name" value = "'.$autoname.'">
							</td>
						</tr>
						<tr>
							<td>Ваша почта<span class="red">*</span></td>
							<td>
								<input type="email" name="email" value = "'.$autoemail.'">
							</td>
						</tr>
						<tr>
							<td>Ваш номер<span class="red">*</span></td>
							<td>
								<input type="text" name="phonenumber">
							</td>
						</tr>
						<tr>
							<td>Ваш адрес<span class="red">*</span></td>
							<td>
								<input type="text" name="adress">
							</td>
						</tr>
						<tr>
							<td>Дата<span class="red">*</span></td>
							<td>
								<input type="text" name="dateorder">
							</td>
						</tr>																		        
						<tr>
                        <td colspan="2">
                            <input type="submit" class ="inline_order" name="btn_submit_order" value="Оформить.">
                        </td>
                   		</tr>
						</tbody>
					</table>';
				?>
				<div class="block_for_messages"> 
				<?php         
        if(isset($_SESSION["error_messages"]) && !empty($_SESSION["error_messages"])){
            echo '
            <div class = "err_mess">
                 '.$_SESSION["error_messages"].'
             </div>';
 
            
            unset($_SESSION["error_messages"]);
        }
 

        if(isset($_SESSION["success_messages"]) && !empty($_SESSION["success_messages"])){
            echo '
            <div class = "succ_mess">
                 '.$_SESSION["success_messages"].'
             </div>';
             echo '
             <script>
             $(document).ready(function() {
             	$("#orderform").submit(function() {
             		$.ajax({
             			type: "POST",
             			url: "mail.php",
             			data: $(this).serialize()
             			});
             			return false;
             			});
             			});
             </script>';
            unset($_SESSION["success_messages"]);
        }         
        ?>
        </div>
    </form>		
		</div>
	</section>	   
	<footer>
<div class="footer">
<div class="up-arrow">
<a class="scroll" href="#home"><img src="img/up.png" alt="" /></a>
</div>
<div class="container">
<div class="copyrights">
<p>ПМ-172 &copy; 2019-2020г.</p><p>Не копируй, а то бан!</p>
</div>
</div>
</div>
</footer>
</body>
</html>