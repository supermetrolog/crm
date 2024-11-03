<?

function solution(array $arr){
    //вспомогательный массив с положительными
    $pos = [];
    foreach($arr as $item){
        //если больше нуля то набираем
        if($item > 0){
            $pos[] = $item;
        }
    }

    //набрали только положительные и едем дальше
    $amount = count($pos);

    //сортируем пузырьком то есть сравниваем соседей меньший влево больший вправо
    for($i = 0; $i < $amount-1; $i++){
        for($j = $i+1; $j < $amount; $j++){
            if($pos[$i] > $pos[$j]){
                $buffer = $pos[$j];
                $pos[$j] = $pos[$i];
                $pos[$i] = $buffer;
            }
        }
    }



    var_dump($pos);

    //ну и бежим от 1 до миллиона по условию и если этого числа нету в массиве отсортированном по возрастанию
    //то его возвращаем и все)
    for($i=1; $i <= 10000000; $i++){
        if(!in_array_oleg($i,$pos)){
            return $i;
        }
    }



}

//эта функция говорит есть ли число вмассиве или нет)
function in_array_oleg($needle, array $arr){
    foreach($arr as $item){
        if($needle == $item){
            return true;
        }
    }
    return false;
}

echo solution([-2,-4,-5,9,7,1,987,3,9,999,439,2000,20,32,1,2,1000,-44]);