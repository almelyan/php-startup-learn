<?php
    session_start();
    include 'template/header.php';
    include 'template/navbar.php';
?>
<!-- Main jumbotron for a primary marketing message or call to action -->
<div id="main-jumbotron" class="jumbotron">
    <div class="container">
        <h1>Nearby School</h1>
        <p style="color:#FFF;">Education in Turkey is governed by a national system which was established in accordance with the Atatürk Reforms after the Turkish War of Independence. It is a state-supervised system designed to produce a skillful professional class for the social and economic institutes of the nation.</p>
        <p><a class="btn btn-primary btn-lg" href="city.php" role="button">
                <i class="glyphicon glyphicon-search"></i> Find School Now &raquo;</a></p>
    </div>
</div>

<div class="container">
    <!-- Example row of columns -->
    <div class="row">
        <div class="col-md-4">
            <h2>Education in Turkey</h2>
            <p>Education in Turkey is governed by a national system which was established in accordance with the Atatürk Reforms after the Turkish War of Independence. It is a state-supervised system designed to produce a skillful professional class for the social and economic institutes of the nation.</p>
            <p><a target="_blank" class="btn btn-default" href="https://en.wikipedia.org/wiki/Education_in_Turkey" role="button">Read details &raquo;</a></p>
        </div>
        <div class="col-md-4">
            <h2>History</h2>
            <p>After the foundation of the Turkish republic the organization of the Ministry of Education gradually developed and was reorganized with the Law no 2287 issued in 1933. The Ministry changed its names several times. It fell under the Ministry of Culture (1935–1941 and was named Ministry of National Education, Youth, and Sports (1983–1989). Since then it is called the Ministry of National Education.</p>
            <p><a target="_blank" class="btn btn-default" href="https://en.wikipedia.org/wiki/Education_in_Turkey" role="button">Read more &raquo;</a></p>
        </div>
        <div class="col-md-4">
            <h2>Primary Education</h2>
            <p>Primary school (Turkish: İlköğretim Okulu) lasts 4 years. Primary education covers the education and teaching directed to children between 6–14, is compulsory for all citizens, boys or girls, and is given free of charge in public schools. Primary education institutions are schools that provide eight years of uninterrupted education, at the end of which graduates receive a primary education diploma.</p>
            <p><a target="_blank" class="btn btn-default" href="https://en.wikipedia.org/wiki/Education_in_Turkey" role="button">Read details &raquo;</a></p>
        </div>
    </div>

    <hr>

    <footer>
        <p>&copy; 2018 Nearby, Inc.</p>
    </footer>
</div> <!-- /container -->

<?php include 'template/footer.php'; ?>