<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>

<main class="main-grid-box">
  <h1>Welcome to PHP Motors!</h1>
  <section>
    <h2>DMC Delorean</h2>
    <p>3 Cup holders</p>
    <p>Superman doors</p>
    <p>Fuzzy dice!</p>
    <div class="mainimgbox">
      <picture>
        <source media="(min-width:465px)" srcset="/phpmotors/images/delorean.jpg">
        <img src="/phpmotors/images/vehicles/delorean.jpg" alt="hand drawn DMC Dolorean">
      </picture>

      <button type="button" onclick="">
        Own Today
      </button>
    </div>
  </section>
  <article>
    <h2>DMC Delorean Reviews</h2>
    <ul>
      <li>
        "So fast it's almost like traveling in time." (4/5)
      </li>
      <li>
        "Coolest ride on the road." (4/5)
      </li>
      <li>
        "I'm feeling Marty McFly!" (5/5)
      </li>
      <li>
        "The most futuristic ride of our day." (4.5/5)
      </li>
      <li>
        "80's livin and I love it!" (5/5)
      </li>
    </ul>
  </article>
  <aside>
    <h2>
      Delorean Upgrades
    </h2>
    <div class="upgrades">
      <figure>
        <div>
          <img src="/phpmotors/images/upgrades/flux-cap.png" alt="delorean flux capacitor">
        </div>
        <figcaption><a href="#">Flux Capacitor</a></figcaption>
      </figure>
      <figure>
        <div>
          <img src="/phpmotors/images/upgrades/flame.jpg" alt="delorean flame decal">
        </div>
        <figcaption><a href="#">Flame Decals</a></figcaption>
      </figure>
      <figure>
        <div>
          <img src="/phpmotors/images/upgrades/bumper_sticker.jpg" alt="delorean bumper stickers">
        </div>
        <figcaption><a href="#">Bumper Stickers</a></figcaption>
      </figure>
      <figure>
        <div>
          <img src="/phpmotors/images/upgrades/hub-cap.jpg" alt="delorean hub caps">
        </div>
        <figcaption><a href="#">Hub Caps</a></figcaption>
      </figure>
    </div>
  </aside>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>