<?php

class Benchmark
{
    private $targets;
    private $iterations = 1000;
    private $results;
    
    public function addTarget($name, $target, array $parameters = array())
    {
        if (!is_callable($target)) {
            trigger_error('A target has to be a valid callable', E_USER_ERROR);
        }
        
        $this->targets[$name] = array(
            'callable' => $target, 'parameters' => $parameters
        );
        
        return $this;
    }
    
    public function setIterations($iterations)
    {
        $this->iterations = $iterations;
        
        return $this;
    }
    
    public function execute()
    {
        foreach ($this->targets as $name => $target) {
            $this->results[$name] = $this->doBench($target);
        }
        
        asort($this->results);
        
        foreach ($this->results as $name => $time) {
            if (!isset($minTime)) {
                $minTime = $time;
                $this->results[$name] = '100%';
                continue;
            }
            
            $this->results[$name] = round($time / $minTime * 100) . '%';
        }
        
        return $this->results;
    }
    
    private function doBench($target)
    {
        $startTime = microtime(true);
        
        for ($i=0; $i<$this->iterations; $i++) {
            call_user_func_array($target['callable'], $target['parameters']);
        }
        
        return microtime(true) - $startTime;
    }
}