<section class="dashboard">
    <div class="dashboard_options">
        <form class="dashboard_sort" action="<?=$app->url->create('dashboard')?>" method="GET">
            <p>Sort by:</p>
            <select class="" name="sort" onchange="submit()">
                <option value="">-</option>
                <option value="id">ID</option>
                <option value="username">Username</option>
                <option value="admin">Admin</option>
            </select>
        </form>
        <form class="dashboard_search" action="<?=$app->url->create('dashboard')?>" method="GET">
            <p>Search:</p>
            <input type="text" name="search" value="">
            <input type="submit">
        </form>
    </div>

    <?=$app->dashboard->getHTML()?>

<!-- <a href="" class="next pagination">
    >
</a>

<a href="" class="prev pagination">
    <
</a> -->

</section>
