
<header class="blog-header py-3">
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark justify-content-between">
  <a class="navbar-brand" href="/<?php echo $currentPage->getName(); ?>"><img src="../../_assets/images/brain.jpg" id="top" class="rounded" width="30px" height="25px"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <?php 
        foreach ($pages as $loopPage) {
          # code...
          if($loopPage->getName()!='category' && $loopPage->getName()!='article' && $loopPage->getName()!='inscription' && $loopPage->getName()!='connexion' && $loopPage->getName()!='monCompte' && $loopPage->getName()!='administration' )
          {
            echo '<li class="nav-item">
              <a class="nav-link text-capitalize '.(($currentPage->getName()==$loopPage->getName()) ? 'active' : '').'" href="/'.$loopPage->getName().'">'.$loopPage->getName().'</a>
            </li>';
          }elseif (($loopPage->getName()!='monCompte' || $loopPage->getName()!='administration') && isset($_SESSION['member']) ) {
            $member = unserialize($_SESSION['member']);
            if($loopPage->getName()=='monCompte')
            {
              echo '<li class="nav-item">
                <a class="nav-link text-capitalize '.(($currentPage->getName()==$loopPage->getName()) ? 'active' : '').'" href="/'.$loopPage->getName().'">'.$loopPage->getName().'</a>
              </li>';
            }elseif($loopPage->getName()=='administration') {
              if($member->getPrivilegeId()=='-1')
              {
                echo '<li class="nav-item">
                  <a class="nav-link text-capitalize '.(($currentPage->getName()==$loopPage->getName()) ? 'active' : '').'" href="/'.$loopPage->getName().'">'.$loopPage->getName().'</a>
                </li>';
              }
            }
          }
        }
      ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Categories
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <?php
            foreach ($categories as $category) {
              # code...
                echo '<a class="dropdown-item text-capitalize" href="/category?name='.$category->getName().'&id='.$category->getId().'">'.$category->getName().'</a>';
            }
          ?>
        </div>
      </li>
      <?php
        if(isset($_SESSION['member']))
        {
          echo
          '<li class="nav-item">
              <form method="post">
                <input type="submit" class="btn btn-outline-warning ml-1 my-2 my-sm-0 " name="writeArticle" value="Ecrire">
              </form>
           </li>
          ';
        }
      ?>
    </ul>
      <?php
        if(isset($_SESSION['member']))
        {
          echo 
          '
          <form method="post">
            <input type="submit" class="btn btn-outline-danger ml-1 my-2 my-sm-0 " name="logout" value="Deconnexion">
          </form>
          ';
        }else{
          echo 
          '
          <button class="btn btn-outline-warning ml-1 my-2 my-sm-0 " onclick="window.location.href=\'/inscription\';"><a>Inscription</a></button>
          <button class="btn btn-outline-success ml-1 my-2 my-sm-0 " onclick="window.location.href=\'/connexion\';"><a>Connexion</a></button>
          ';
        }
      ?>
  </div>
</nav>
<?php

  switch ($mode) {
    case 'dev':
      echo "<p class='mt-5'>Error(s) Dev Stack :</p>";
      foreach ($errorStack as $errorMessage){
        echo "\n<p>".$errorMessage."</p>";}
      break;
  }

?>
</header>