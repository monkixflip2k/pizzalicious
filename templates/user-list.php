<div class="userlist_block">
    <div class="userlist_block_content">
        <form name="search" method="get" action="pageView.php">
            <input type="search" name="user" placeholder="Поиск">
            <input style="visibility:hidden" type="niggaalarm" name="id" value="user-list.php">
            <button type="submit">Найти</button>
        </form>
        <p>Список пользователей</p>
        <div>
            <table>
                <thead>
                    <tr>
                        <th>Имя пользователя</th>
                        <th>Хешированный пароль</th>
                    </tr>
                </thead>
                <tbody>
                <?php
if (isset($_GET["user"]) && $_GET["user"] !== "") {
    $user = $_GET["user"];
    $db_host = 'localhost';
    $db_username = 'root';
    $db_password = '';
    $db_name = 'pizza_bd';
    $conn = new mysqli($db_host, $db_username, $db_password, $db_name);
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();
    echoUsers($result);
    $conn->close();
} else {
    $db_host = 'localhost';
    $db_username = 'root';
    $db_password = '';
    $db_name = 'pizza_bd';
    $conn = new mysqli($db_host, $db_username, $db_password, $db_name);
    $sql = "SELECT * FROM users LIMIT 10"; 
    $result = $conn->query($sql);
    echoUsers($result);
    $conn->close();
}

function echoUsers($result)
{
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["username"] . "</td>";
            echo "<td>" . $row["password"] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='3'>0 результатов</td></tr>";
    }
}
?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
        header{
          position: inherit;
        }
      </style>