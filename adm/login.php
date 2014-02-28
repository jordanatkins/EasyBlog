  <link href="../assets/css/bootstrap.min.css" rel="stylesheet">

    <div class="container">
      <div class="well well-small">
	<form class="login" action="admin.php?mode=login" method="post">
		<h2>Please login</h2>
		<p>Please input your username and password to continue to the admin panel.</p>

		<span class="error-text text-error"><?=$error_text?></span><br>

			<input id="password" size="30" type="password" name="password" placeholder="Password"/>

		<p><input class="btn btn-success" type="submit" name="SimplePoll_Login" value="Login" /></p>
	</form>
</div>
    </div>
