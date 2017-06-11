#! /bin/sh
IP=123.206.177.73
USER=root
PSWD=mcyHiMBdYBvMyH9k
source_dir=../home
dest_dir=/home/wwwroot/wx.97qingnian.com/

#clean dir


#upload file
echo "o uploading..."
expect -c "
  set timeout 1
  spawn scp -r $source_dir $USER@$IP:$dest_dir
  expect yes/no { send yes\r ; exp_continue }
  expect password: { send $PSWD\r }
  interact
"
echo 🎉🎉🎉
