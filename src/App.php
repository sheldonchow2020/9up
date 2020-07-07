<?php

namespace NineUp;

class App
{

    protected $topic;

    protected $famous;
    protected $before;
    protected $after;

    public function __construct()
    {
        $dataJson = file_get_contents(dirname(__FILE__) . '/sentense.json');
        $data = json_decode($dataJson, true);

        $this->famousGenerater = $this->sentenceGenerater($data['famous']);
        $this->otherGenerater = $this->sentenceGenerater($data['connect']);
        $this->endGenerater = $this->sentenceGenerater($data['end']);
        $this->before = $data['before'];
        $this->after = $data['after'];
    }

    public function sentenceGenerater($sentenseList)
    {
        shuffle($sentenseList);

        while (1) {
            foreach ($sentenseList as $item) {
                yield $item;
            }
        }
    }

    public function pickAFamous()
    {
        $sentense = $this->famousGenerater->send(null);

        $sentense = str_replace('a', $this->randPick($this->before), $sentense);
        $sentense = str_replace('b', $this->randPick($this->after), $sentense);

        return $sentense;
    }

    public function pickAnOther()
    {
        return $this->otherGenerater->send(null);
    }

    public function pickAnEnd()
    {
        return $this->endGenerater->send(null);
    }

    public function randPick(array $array)
    {
        $key = mt_rand(0, count($array) - 1);
        return $array[$key];
    }

    public function setTopic(string $topic)
    {
        $this->topic = $topic;
    }

    public function write(int $qty = 100)
    {
        $totalQty = 0;
        $content = '    ';

        while ($totalQty <= $qty) {
            $eventNum = mt_rand(0, 100);
            if ($eventNum < 5) {
                //换行
                $content && $content .= $this->pickAnEnd() . "\n    ";
            } else if ($eventNum < 20) {
                $content .= $this->pickAFamous();
            } else {
                $content .= $this->pickAnOther();
            }

            $totalQty++;
        }

        $content .= $this->pickAnEnd() . "\n";

        return str_replace('x', $this->topic, $content);
    }
}
