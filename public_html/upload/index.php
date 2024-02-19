<!DOCTYPE html>
<html>

<head>
  <style>
    #drop_zone {
      border: 5px solid blue;
      width: 50vw;
      height: 50vh;
    }
  </style>
  <script>
    function dropHandler(ev) {
      console.log("File(s) dropped");

      // Prevent default behavior (Prevent file from being opened)
      ev.preventDefault();

      if (ev.dataTransfer.items) {
        // Use DataTransferItemList interface to access the file(s)
        [...ev.dataTransfer.items].forEach((item, i) => {
          // If dropped items aren't files, reject them
          if (item.kind === "file") {
            const file = item.getAsFile();
            fetch('upload.php', {
              method: 'POST',
              body: file
            })
              .then((response) => {
                if (!response.ok) {
                  throw new Error(`Erreur HTTP : ${response.status}`);
                }
                return response;
              })
              .catch((err) => console.error(`Problème avec Fetch : ${err.message}`));
          }
        });
      } else {
        // Use DataTransfer interface to access the file(s)
        [...ev.dataTransfer.files].forEach((file, i) => {
          fetch('upload.php', {
            method: 'POST',
            body: file[i]
          })
            .then((response) => {
              if (!response.ok) {
                throw new Error(`Erreur HTTP : ${response.status}`);
              }
              return response;
            })
            .catch((err) => console.error(`Problème avec Fetch : ${err.message}`));
          // console.log(`… file[${i}].name = ${file.name}`);
        });
      }
    }

    function dragOverHandler(ev) {
      //console.log("File(s) in drop zone");

      // Prevent default behavior (Prevent file from being opened)
      ev.preventDefault();
    }

  </script>
</head>

<body>

  <form action="upload.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload" multiple>
    <input type="submit" value="Upload Image" name="submit">
  </form>

  <div id="drop_zone" ondrop="dropHandler(event);" ondragover="dragOverHandler(event);">
    <p>Drag one or more files to this <i>drop zone</i>.</p>
  </div>

</body>

</html>