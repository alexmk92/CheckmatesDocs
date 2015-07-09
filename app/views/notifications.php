<?php

require("./app/core/SectionBuilder.php");
require("./app/core/NavigationBuilder.php");

$renderer = new SectionBuilder();

?>

<section class="getRequests" id="get">
    <section class="wrapper">
        <h2>GET Requests</h2>
        <?php

        ?>
    </section>
</section>


<section class="putRequests" id="put">
    <section class="wrapper">
        <h2>PUT Requests</h2>
        <?php
        $navigation->addItem("PUT Requests", "delete", true);
        ?>
    </section>
</section>



<section class="postRequests" id="post">
    <section class="wrapper">
        <h2>POST Requests</h2>
        <?php
        $navigation->addItem("POST Requests", "delete", true);
        ?>
    </section>
</section>



<section class="deleteRequests" id="delete">
    <section class="wrapper">
        <h2>DELETE Requests</h2>
        <?php
        $navigation->addItem("DELETE Requests", "delete", true);
        ?>
    </section>
</section>


<?php
$navigation->renderNavigationBar();
?>
