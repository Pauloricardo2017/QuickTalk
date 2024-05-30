<?php
include("check.php");

// Query to get conversations where the user is involved
$stmt = $con->prepare("SELECT * FROM conversations WHERE (MainUser = ? OR OtherUser = ?) ORDER BY Modification DESC");
$stmt->bind_param("ii", $uid, $uid);
$stmt->execute();
$result = $stmt->get_result();
$count = $result->num_rows;

if ($count < 1) {
    echo '<div class="empty"><p>Pesquise um utilizador e começe um chat!</p></div>';
}

$newMessage = false;

while ($inbox = $result->fetch_assoc()) {
    $otherUserId = ($inbox["MainUser"] == $uid) ? $inbox["OtherUser"] : $inbox["MainUser"];
    $stmt2 = $con->prepare("SELECT Id, Username, Picture FROM User WHERE Id = ? LIMIT 1");
    $stmt2->bind_param("i", $otherUserId);
    $stmt2->execute();
    $user = $stmt2->get_result()->fetch_assoc();

    if ($user) {
        if ($inbox["Unread"] == "y" && $inbox["OtherUser"] == $uid) {
            $newMessage = true;
        }
?>
        <div class="chat <?php if ($inbox["Unread"] == "y" && $inbox["OtherUser"] == $uid) {
                                echo "new";
                            } ?>" onclick="chat('<?php echo $user['Id']; ?>')">
            <img src="profilePics/<?php echo $user["Picture"]; ?>" />
            <p><?php echo $user["Username"]; ?></p>
        </div>
<?php
    }
}

if ($newMessage) {
    echo '<div id="newMessageAlert" style="display:none;">nova mensagem</div>';
}
?>