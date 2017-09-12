function scopeSetData(scope, data){
	console.log('scopesetdata');
	if(typeof data !== 'object'){
		console.log(1);
		return;
	}
	else{
		console.log(2);
		for(var dataKey in data){
			if(!data.hasOwnProperty(dataKey)) continue;
			scope[dataKey] = data[dataKey];
		}
	}
}