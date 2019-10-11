i=0
 while [ "$i" -le 60 ] 
do 
rm -rf real_data
mkdir real_data
php ./GetReal.php &
php ./ClearRealTable.php &
sleep 5
php ./ImportRealData.php &

sleep 60

 i=`expr $i + 1` 
done
