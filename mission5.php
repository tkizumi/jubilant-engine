<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission5-1</title>
</head>
<body>
    <?php
        echo "テーマ：好きな歌手"
    ?>
    
    <?php
    
        // DB接続設定
        $dsn = 'データベース名';
        $user = 'ユーザー名';
        $password = 'パスワード';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
        // table作成
        $sql = "CREATE TABLE IF NOT EXISTS tbsing"
        ." ("
        . "id INT AUTO_INCREMENT PRIMARY KEY,"
        . "name char(32),"
        . "comment TEXT"
        .");";
        $stmt = $pdo->query($sql);
    
        //送信or編集or削除分岐
        if(isset($_POST["name"])){  //送信ボタンが押された時
            if($_POST["name"] == "" || $_POST["comment"] == ""){  //入力された内容が空欄の時
              //何もしない
              
            }else{  //入力されているとき
                if($_POST["password1"] == "mission5-1"){
                    if($_POST["sub_number"] == ""){
                        //新規投稿モード
                        $sql = $pdo -> prepare("INSERT INTO tbsing (name, comment) VALUES (:name, :comment)");
                        $sql -> bindParam(':name', $name, PDO::PARAM_STR);
                        $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
                        $name = $_POST["name"];
                        $comment = $_POST["comment"]; //好きな名前、好きな言葉は自分で決めること
                        $sql -> execute();
                
                    }else{
                        //編集モード
                        $id = $_POST["sub_number"]; //変更する投稿番号
                        $name = $_POST["name"];
                        $comment = $_POST["comment"]; //変更したい名前、変更したいコメントは自分で決めること
                        $sql = 'UPDATE tb5 SET name=:name,comment=:comment WHERE id=:id';
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                        $stmt->execute();
                        
                    }
                }else{
                  //何もしない
                }
            }
        
        }elseif(isset($_POST["ed_number"])){  //編集ボタンが押された時
            if($_POST["ed_number"] == ""){  //空欄の時
              //何もしない
              
            }else{  //入力されているとき
                if($_POST["password2"] == "mission5-1"){
                    $id = $_POST["ed_number"]; // idがこの値のデータだけを抽出したい、とする
                    $sql = 'SELECT * FROM tb5 WHERE id=:id ';
                    $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
                    $stmt->execute();                             // ←SQLを実行する。
                    $results = $stmt->fetchAll(); 
                    foreach ($results as $row){
                        //$rowの中にはテーブルのカラム名が入る
                        $newname = $row['name'];
                        $newcomment = $row['comment'];
                    }
                
                }else{
                  //何もしない
                  
                }
    
            }
            
        }elseif(isset($_POST["de_number"])){  //削除ボタンが押された時
            if($_POST["de_number"] == ""){  //空欄の時
              //何もしない
            
            }else{  //入力されているとき
                if($_POST["password3"] == "mission5-1"){
                    $id = $_POST["de_number"];
                    $sql = 'delete from tbsing where id=:id';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                    
                }else{
                  //何もしない
                  
                }
            }
            
        }else{  //ボタンが押されていないとき
            //何もしない
        }
    ?>
    
    <form action="" method="post">
        <input type="text" name="name" value="<?php if(isset($_POST["ed_number"])){
                                                        if($_POST["ed_number"] == ""){
                                                        
                                                        }else{
                                                            if($_POST["password2"] == "mission5-1"){
                                                                echo $newname;
                                                            }
                                                        }
                                                    }    
                                              ?>" placeholder="名前を入力してください">
        <input type="text" name="comment" value="<?php if(isset($_POST["ed_number"])){
                                                            if($_POST["ed_number"] == ""){
                                                        
                                                            }else{
                                                                if($_POST["password2"] == "mission5-1"){
                                                                    echo $newcomment;
                                                                }
                                                            }
                                                       }    
                                                 ?>" placeholder="コメントを入力してください">
        <input type="hidden" name="sub_number" value="<?php if(isset($_POST["ed_number"])){
                                                              if($_POST["ed_number"] == ""){
                                                        
                                                              }else{
                                                                  if($_POST["password2"] == "mission5-1"){
                                                                      echo $_POST["ed_number"];
                                                                  }
                                                              }
                                                            }    
                                                      ?>" >
        <input type="text" name="password1" placeholder="パスワードを入力してください">
        <input type="submit" name="send" value="送信">
    </form>
        
    <form action="" method="post">
        <input type="number" name="de_number" placeholder="削除対象番号入力">
        <input type="text" name="password3" placeholder="パスワードを入力してください">
        <input type="submit" name="delete" value="削除">
    </form>
    
    <form action="" method="post">
        <input type="number" name="ed_number" placeholder="編集対象番号入力">
        <input type="text" name="password2" placeholder="パスワードを入力してください">
        <input type="submit" name="edit" value="編集">
    </form>
    
    <?php
    
        //ブラウザ表示。
        $sql = 'SELECT * FROM tbsing';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            //$rowの中にはテーブルのカラム名が入る
            echo $row['id'].',';
            echo $row['name'].',';
            echo $row['comment'].'<br>';
        echo "<hr>";
        }
        
    ?>
    
</body>
</html>