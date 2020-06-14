<div class="titulo">
	<h1>E-mails - Editar E-mail</h1>
</div>

<?php if(isset($error) && !empty($error)): ?>
    <div class="alert alert_warning">
        <?php echo $error; ?>
    </div>
<?php endif; ?>

<form method="POST">
	<label for="recipient">Destinatário</label><br/>
	<input type="text" name="recipient" value="<?php echo $email['recipient']; ?>" required/><br/><br/>

	<label for="subject_matter">Assunto</label><br/>
	<input type="text" name="subject_matter" value="<?php echo $email['subject_matter']; ?>" required/><br/><br/>

	<label for="body">Corpo do E-mail</label><br/>
	<textarea name="body"/><?php echo $email['body']; ?></textarea><br/><br/>

	<input type="submit" value="Salvar"/>
</form>