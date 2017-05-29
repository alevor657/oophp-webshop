        </main>
        <footer>
            <?php
            $data = $app->content->getDataByTitle('footer');
            echo $app->filter->doFilter($data->data, $data->filter);
            ?>
            <br>
            <p>2017 &copy;</p>
        </footer>

        <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/2.7.2/less.min.js"></script>
        <script src="<?= $app->url->asset('js/modal.js') ?>"></script>
    </body>
</html>
