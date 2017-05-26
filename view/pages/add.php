<div class="edit_wrapper">
    <form class="" action="<?=$app->url->create('content/edit/createContent')?>" method="post">
        <table class="dashboard_table">
            <tr>
                <th>Title</th>
                <th>Type</th>
                <th>Path</th>
                <th>Slug</th>
                <th>Filters</th>
                <th>Published</th>
            </tr>


            <tr>
                <td>
                    <input type="text" name="title" required>
                </td>
                <td>
                    <select name="type">
                        <option value="page">page</option>
                        <option value="post">post (blog)</option>
                        <option value="block">block</option>
                    </select>
                </td>
                <td>
                    <input type="text" name="formPath" required>
                </td>
                <td>
                    <input type="text" name="slug">
                </td>
                <td>
                    <input type="text" name="filter" value="bbcode, markdown, nl2br, link">
                </td>
                <td>
                    <input type="date" name="published">
                </td>
            </tr>
        </table>
            <textarea class="edit_data_input" name="data" rows="8" cols="80"></textarea>
            <input class="edit_data_submit" type="submit" value="Save">
    </form>
</div>
