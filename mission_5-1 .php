<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>mission5SQLver</title>
</head>
<body>
       //記入フォームを作成:投稿、削除、編集
        <form action="" method="post">
            <input type="string" name="name" placeholder="Name"><br>
            <input type="string" name="comment" placeholder="Comment">
            <input type="submit" name="submit"> <br><br>
            <input type="number" name="dstep" placeholder="Delete Number">
            <button type="submit" name="dflag" value=1 >削除</button><br>
            <input type="number" name="estep" >
            <button type="submit" name="eflag" value=1>編集</button>
        </form>
        <?php
        //Mysqlに接続
        $dsn = 'データベース名';
	    $user = 'ユーザー名';
	    $password = 'パスワード';
	    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        
        //新規投稿関係 
            $name = $_POST["name"];
            $comment = $_POST["comment"];
            $submitDate = date("Y/m/d/ H:i:s");
        //削除関係
            $dstep = $_POST["dstep"];
            $dflag = $_POST["dflag"];
        //編集関係
            $estep = $_POST["estep"];
            $eflag = $_POST["eflag"];
          
        //削除:4-8のDELEATE文を用いる。
            if($dflag == 1){
                $sql = $pdo -> prepare("DELETE FROM mission5 WHERE id = :id");
	            $sql->bindParam(':id', $dstep);
                $sql -> execute();
       //編集:4-7のUPDATE文を用いる。
            }elseif($eflag == 1){
	            $id = $estep; //変更する投稿番号
	            $sql = 'UPDATE mission5 SET name=:name,comment=:comment WHERE id=:id';
	            $stmt = $pdo->prepare($sql);
	            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
	            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	            $stmt->bindParam(':id', $estep);
	            $stmt->execute();
            }else{
        //データ入力:4-5のINSERT文を用いる。
            if(!empty($name && $comment)){
	            $sql = $pdo -> prepare("INSERT INTO mission5 (name, comment, submitDate) VALUES (:name, :comment, :submitDate)");
	            $sql -> bindParam(':name', $name, PDO::PARAM_STR);
	            $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	            $sql -> bindParam(':submitDate', $submitDate);
	            $sql -> execute();
                }
            }
        //表示
        echo "表示中"."<br>";
        $sql  =  'SELECT * FROM mission5';
        $stmt =  $pdo->query($sql);
	    $results = $stmt->fetchAll();
	    foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		    echo $row['id'].',';
		    echo $row['name'].',';
		    echo $row['comment'].',';
		    echo $row['submitDate'].'<br>';
	        echo "<hr>";
	    }
        ?>
</body>
</html>