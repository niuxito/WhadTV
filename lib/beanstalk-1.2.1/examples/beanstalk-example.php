<?php

    /**
    * BeanStalk 0.10 - Example code
    * 
    * This is a quick example to get you started using the client.
    */
    
    require('BeanStalk.class.php');
    
    /**
    * Connect to the beanstalkd server(s)
    * 
    * Option array:
    * 
    *       array(
    *           'servers'               => array( 'ip:port'[, 'ip:port'[, ...]] ),
    *           'select'                => 'random wait',
    *           'connection_timeout'    => 0.5,
    *           'peek_usleep'           => 2500,
    *           'connection_retries'    => 3,
    *           'auto_unyaml'           => true
    *       );
    * 
    * select -> this tells the client what type of blocking to use when selecting from 
    * different servers. There are currently four choices:
    * 
    *   random wait:        pick a random server from the list and wait for a job
    * 
    *   sequential wait:    pick the next server in the list and wait for a job
    * 
    *   random peek:        in a loop, pick a random server and peek-ready(), looking for a job
    *                       until a server is found that has something available.
    * 
    *   sequential peek:    in a loop, pick the next server and peek-ready() ... etc.
    * 
    * the *peek modes have a companion setting, peek_usleep, which tells the client how long
    * to usleep() for between peeks to servers.
    * 
    * auto_unyaml -> if true, this causes the client to assume the presence of the syck yaml
    * parser, and attempts to 'unyamlize' yaml output for you before returning it.
    */
    $beanstalk = BeanStalk::open(array(
        'servers'       => array( '127.0.0.1:11300' ),
        'select'        => 'random peek'
    ));
    
    // As in the protocol doc.
    $beanstalk->use_tube('foo');
    
    // As in the protocol doc.
    $beanstalk->put(0, 0, 120, 'say hello world');      // Add a job to the queue with highest priority, 
                                                        // no delay, 120 seconds TTR, with the contents
                                                        // 'say hello world'.
                                                        
                                                        // NOTE: the put() method here supports a final optional 
                                                        // argument, a tube name. If supplied, the server will
                                                        // first switch to that tube, write the job, then switch
                                                        // back to the old tube again.
    
    // As in the protocol doc.
    $job = $beanstalk->reserve();                       // Assuming there was nothing in the queue before 
                                                        // we started, this will give us our 'hello world'
                                                        // job back.
    
    // This is a BeanQueueJob object.
    echo $job->get();                                   // Output: 'say hello world'
    
    Beanstalk::delete($job);                            // Delete the job.

?>
