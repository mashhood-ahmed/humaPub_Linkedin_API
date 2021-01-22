<?php 
    require('./config.php');

    $url = "https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=".CLIENT_ID."&redirect_uri=".REDIRECT_URL."&scope=".SCOPES;

    ?>
 
    <a href="<?php echo $url; ?>">Share On LinkedIn</a>

