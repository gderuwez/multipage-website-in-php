<?php
function content($im1, $im1a, $bname, $bcontent, $s1name, $s1content, $s21im, $s21ima, $s2h1name, $s2h1content, $s22im, $s22ima, $s2h2name, $s2h2content, $s3name, $s3content){
echo <<<EOL
<!-- Banner -->
<!-- Note: The "styleN" class below should match that of the header element. -->
  <section id="banner" class="style2">
    <div class="inner">
      <span class="image">
        <img src=$im1 alt=$im1a />
      </span>
      <header class="major">
        <h1>$bname</h1>
      </header>
      <div class="content">
        <p>$bcontent</p>
      </div>
    </div>
  </section>

<!-- Main -->
  <div id="main">

    <!-- One -->
      <section id="one">
        <div class="inner">
          <header class="major">
            <h2>$s1name</h2>
          </header>
          <p>$s1content</p>
        </div>
      </section>

    <!-- Two -->
      <section id="two" class="spotlights">
        <section>
          <a href="generic.html" class="image">
            <img src="$s21im" alt="$s21ima" data-position="center center" />
          </a>
          <div class="content">
            <div class="inner">
              <header class="major">
                <h3>$s2h1name</h3>
              </header>
              <p>$s2h1content</p>
            </div>
          </div>
        </section>
        <section>
          <a href="generic.html" class="image">
            <img src="$s22im" alt="$s22ima" data-position="top center" />
          </a>
          <div class="content">
            <div class="inner">
              <header class="major">
                <h3>$s2h2name</h3>
              </header>
              <p>$s2h2content</p>
            </div>
          </div>
        </section>
      </section>

    <!-- Three -->
      <section id="three">
        <div class="inner">
          <header class="major">
            <h2>$s3name</h2>
          </header>
          <p>$s3content</p>
        </div>
      </section>

  </div>

EOL;
}

 ?>
