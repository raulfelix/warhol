<?php
/**
 * Template Name: subscribe
 */

  get_header();
?>

<div class="article-row form-row f-grid f-row">
  <div class="f-1">
    <div class="section form-row-content">
      <h1>Subscribe to our newsletter</h1>
      <p>Enter your email address below to subscribe to a regular(ish) dose of LWA goodness direct to your inbox.</p>
      <div class="form-subscribe">
        <form action="http://blacksaltstudio.createsend.com/t/j/s/hklydk/" method="post">
          <div class="input">
            <input name="cm-hklydk-hklydk" type="email" placeholder="Email address" required />
          </div>
          <button class="button" type="submit">Subscribe</button>
        </form>
      </div>
    </div>
  </div>
</div>  

<?php
  get_footer(); 
?>