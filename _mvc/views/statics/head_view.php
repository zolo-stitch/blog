<head>
<!-- Meta Tags -->
<meta charset="UTF-8"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, user-scalable=0, maximum-scale=1, initial-scale=1.0, maximum-scale=1">
<meta name="author" content="<?= WEBSITE_AUTHOR?>">
<meta name="description" content="<?= WEBSITE_DESCRIPTION?>" />
<meta name="keywords" content="<?= WEBSITE_KEYWORDS?>"/>
<meta name="Reply-to" content="<?= WEBSITE_AUTHOR_MAIL?>">
<meta name="Copyright" content="<?= WEBSITE_AUTHOR?>">
<meta name="Language" content="<?= WEBSITE_LANGUAGE?>">


<!-- Open Graph tags -->
<meta property="og:type"			content="website" />
<meta property="og:url"				content="<?= WEBSITE_FACEBOOK_URL?>" />
<meta property="og:title"			content="<?= WEBSITE_FACEBOOK_NAME?>" />
<meta property="og:description"		content="<?= WEBSITE_FACEBOOK_DESCRIPTION?>" />
<meta proterty="og:image"			content="<?= WEBSITE_FACEBOOK_IMAGE?>" />
<title><?=($currentPage->getName()=='home') ? 'Melimelo' : ucfirst($currentPage->getName()) ?> - Blog</title>
<!-- Custom styles for this template -->
<link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Merriweather:400,900,900i" rel="stylesheet">
<!-- CSS Styles -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<link rel="stylesheet" href="../../_assets/css/normalize.css"/>
<link rel="stylesheet" href="../../_assets/css/rating.css"/>
<link rel="stylesheet" href="../../_assets/css/main.css"/>

<!-- JS Files -->

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

</head>