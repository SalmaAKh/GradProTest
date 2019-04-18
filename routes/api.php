<?php

  


Route::prefix('admin')->group(function () {
    
    
    
    
    
    Route::get('offered_course/browser', function () {
     
        
        return view('offered_course.browser');

        
        
        
    });
        
    
    Route::get('offered_course/new', function () {
     
        
        return view('offered_course.new');

        
        
        
    });
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
});



