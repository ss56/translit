function translit_fun(text1,l1,l2)
    {
        var arr = new Array(); 
        var text_ord = '';
        var common = new Array(32,44,10,2385,2386,2404,2405,2424);
        var special = new Array(2385,2386,3075);
        if(l1>l2)
        {
            diff = parseInt(l1-l2);
        }
        else
        {
            diff = parseInt(l2-l1);
        }
        if(l1 == 2944)
        {
            lang1 = "Tamil";
            l12 = 3053;
        }
        else if(l1 == 3072)
        {
            lang1 = "Telugu";
            l12 = 3199;
        }
        else if(l1 == 2304)
        {
            lang1 = "Hindi";
            l12 = 2491;
        }
        text1 = text1.replace(" ","_u0020");
        text1 += " ";
        
        for(i=0; i<text1.length;i++)
        {
            a = '';
            if(text1[i] == 'u' && i<text1.length)
            {
                i++;
                while(text1[i] != '_' && i<text1.length-1)
                {
                    a += text1[i];
                    i++;
                }

            }
            
            arr.push(a);
        }
        last_ord = null;
        var flag = 0;
        
        for(i=0; i<arr.length;i++)
        {
            if(arr[i] !== ''){
            ord = parseInt(arr[i], 16);
                
            if((ord >= l1 && ord <= l12) || $.inArray(ord,common))
            {
                if(l1>l2 && !$.inArray(ord,common))
                {
                    ord = parseInt(ord)-diff;
                }
                else if(!$.inArray(ord,common))
                {
                    ord = parseInt(ord)+diff;
                    
                }
                    if(parseInt(ord) == 32) alert("space_occured");
                    text_ord += String.fromCharCode(Number(ord));
                   
                
            }
            last_ord = parseInt(ord).toString(16);
            }
        }
        return JSON.parse(JSON.stringify(text_ord));
    }