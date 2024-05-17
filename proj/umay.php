<?php
// Include the database configuration file
require_once 'config.php';

// Get document data from database
$result = mysqli_query($con, "SELECT document, id, filetype FROM documents ORDER BY id DESC");

// Display documents with BLOB data from database
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {  
        // Display documents with BLOB data from database
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['filetype'] === 'pdf') {
                    // Display PDF document
                    echo '<iframe src="data:application/pdf;base64,'. base64_encode($row['document']). '" width="100%" height="600px"></iframe>';
                } elseif ($row['filetype'] === 'txt') {
                    // Display TXT document
                    echo '<pre style="width:100%;height:600px;">'. $row['document']. '</pre>';
                }
            }
        }
    }
} else {
    echo '<p class="status error">Document(s) not found...</p>';
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Upload</title>
</head>
<body>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label>Select Document File:</label>
        <input type="file" name="document" accept=".pdf,.doc,.docx,.txt,.pptx,.xlsx">
        <input type="submit" name="submit" value="Upload">
    </form>
</body>
</html>

<?php
// Include the database configuration file
require_once 'config.php';

// If file upload form is submitted
if (isset($_POST["submit"])) {
    $status = $statusMsg = '';

    // Get file info
    $fileName = basename($_FILES["document"]["name"]);
    //$fileType = pathinfo($fileName, PATHINFO_EXTENSION);

    // Allow certain file formats
    $allowTypes = array('pdf', 'doc', 'docx', 'txt','pptx', 'xlsx');
    if (in_array($fileType, $allowTypes)) {
        $document = $_FILES['document']['tmp_name'];
        $docContent = file_get_contents($document);

        // Get the file type
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Prepare the SQL statement with placeholders for the document content and file type
        $stmt = $con->prepare("INSERT INTO documents (document, filetype, created) VALUES (?, ?, NOW())");
        $stmt->bind_param("ss", $docContent, $fileType);

        // Execute the statement and check for success 
        if ($stmt->execute()) {
            $status = 'success';
            $statusMsg = "Document uploaded successfully.";
        } else {
            $status = 'error';
            $statusMsg = "Document upload failed, please try again.";
        }

        // Close the statement
        $stmt->close();
    } else {
        $status = 'error';
        $statusMsg = 'Sorry, only PDF, DOC, DOCX, & TXT files are allowed to upload.';
    }
}

// Display status message
$_SESSION['statusMsg'] = $statusMsg;
header('Location: display.php');
exit;

// Close the database connection
mysqli_close($con);
?>