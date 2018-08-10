
<!-- Banner -->
<!-- Note: The "styleN" class below should match that of the header element. -->
  <section id="banner" class="style2">
    <div class="inner">
      <span class="image">
        <img src="<?php echo $im1 ?>" alt="<?php echo $im1a ?>" />
      </span>
      <header class="major">
        <h1><?php echo $bname ?></h1>
      </header>
      <div class="content">
        <p><?php echo $bcontent ?></p>
      </div>
    </div>
  </section>

<!-- Main -->
  <div id="main">

    <!-- One -->
      <section id="one">
        <div class="inner">
          <header class="major">
            <h2><?php echo $s1name ?></h2>
          </header>
          <p><?php echo $s1content ?></p>
        </div>
      </section>

    <!-- Two -->
      <section id="two" class="spotlights">
        <section>
          <a href="generic.html" class="image">
            <img src="<?php echo $s21im ?>" alt="<?php echo $s21ima ?>" data-position="center center" />
          </a>
          <div class="content">
            <div class="inner">
              <header class="major">
                <h3><?php echo $s2h1name ?></h3>
              </header>
              <p><?php echo $s2h1content ?></p>
            </div>
          </div>
        </section>
        <section>
          <a href="generic.html" class="image">
            <img src="<?php echo $s22im ?>" alt="<?php echo $s22ima ?>" data-position="top center" />
          </a>
          <div class="content">
            <div class="inner">
              <header class="major">
                <h3><?php echo $s2h2name ?></h3>
              </header>
              <p><?php echo $s2h2content ?></p>
            </div>
          </div>
        </section>
      </section>

    <!-- Three -->
      <section id="three">
        <div class="inner">
          <header class="major">
            <h2><?php echo $s3name ?></h2>
          </header>
          <p><?php echo $s3content ?></p>
        </div>
      </section>
  </div>
