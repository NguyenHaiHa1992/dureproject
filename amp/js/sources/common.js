function scopeSetData(scope, data, callback){
	setTimeout(function() {
		console.log('scopesetdata');
		if(typeof data !== 'object'){
			console.log(1);
			return;
		}
		else{
			console.log(2);
                        console.log(scope[dataKey]);
			for(var dataKey in data){
				if(!data.hasOwnProperty(dataKey)) continue;
				scope[dataKey] = data[dataKey];
			}
                        if(callback){
                            callback();
                        }
		}
	}, 1000);
}