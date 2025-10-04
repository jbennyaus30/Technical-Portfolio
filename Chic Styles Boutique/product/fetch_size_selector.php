<?php

$stmt = $conn->prepare('SELECT * FROM ProductSizes 
                        INNER JOIN Sizes ON ProductSizes.SizeID = Sizes.SizeID 
                        WHERE ProductSizes.ProductID=' . $_SERVER["QUERY_STRING"]);
$stmt -> execute();
$sizes_result = $stmt->get_result();

if ($sizes_result->num_rows == 0) {
    return;
}

$row_num = 0;
$size_options = "";
while ($row_num < $sizes_result->num_rows) {
    $row = $sizes_result->fetch_assoc();
    $size_options = $size_options . '<option value="'.$row["SizeID"].'">'.$row["SizeName"].'</option>';
    $row_num++;
}

echo '
<section class="size-selector">
    <label for="size">Select Size:</label>
    <select id="size" name="size" required>
        <option value="">-- Select a Size --</option>
        '.$size_options.'
    </select>
    <p id="sizeError">Please select a size before adding to the cart.</p>
</section>
';