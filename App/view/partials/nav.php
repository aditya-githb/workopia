<?php

use Framework\Session;
?>
<!-- Nav -->
<header class="bg-blue-900 text-white p-4">
  <div class="container mx-auto flex justify-between items-center">
    <h1 class="text-3xl font-semibold">
      <a href="/">Workopia</a>
    </h1>
    <nav class="space-x-4">
      <?php
      if (Session::check('user')) {
      ?>
        <div class="flex justify-center items-center gap-4">
          <div class="text-white font-semibold">
            Welcome <?= Session::get('user')['name'] ?>!
          </div>
          <form method="POST" action="/auth/logout">
            <input type="submit" value="Logout" class='bg-red-500 p-3 rounded text-white hover:bg-red-600 transition duration-300'">
          </form>
          <a
            href="/listings/create"
            class="bg-yellow-500 hover:bg-yellow-600 text-black px-4 py-2 rounded hover:shadow-md transition duration-300"><i class="fa fa-edit"></i> Post a Job</a>
        </div>
      <?php
      } else {
      ?>
        <a href="/auth/login" class="text-white hover:underline">Login</a>
        <a href="/auth/register" class="text-white hover:underline">Register</a>
      <?php
      }
      ?>

    </nav>
  </div>
</header>