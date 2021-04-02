class Character {
	constructor(dbInfo, skills, attacks) {
		this.id = dbInfo["id"];
		this.name = dbInfo["name"];
		this.strengthScore = dbInfo["strengthScore"];
		this.dexterityScore = dbInfo["dexterityScore"];
		this.constitutionScore = dbInfo["constitutionScore"];
		this.intelligenceScore = dbInfo["intelligenceScore"];
		this.wisdomScore = dbInfo["wisdomScore"];
		this.charismaScore = dbInfo["charismaScore"];
		this.proficiencyBonus = dbInfo["proficiencyBonus"];
		this.charisma = dbInfo["charisma"];
		this.strength = dbInfo["strength"];
		this.dexterity = dbInfo["dexterity"];
		this.constitution = dbInfo["constitution"];
		this.intelligence = dbInfo["intelligence"];
		this.wisdom = dbInfo["wisdom"];
		
		this.skills = skills;
		this.attacks = attacks;
	}
	
	createRollStringSaveThrow(saveType) {
		let resultText = "/r 1d20";
		let modifier = 0;
		
		if(saveType == "str")
		{
			modifier = convertScoreToModifier(this.strengthScore);
			if(this.strength)
				modifier += this.proficiencyBonus;
		}
		else if(saveType == "dex")
		{
			modifier = convertScoreToModifier(this.dexterityScore);
			if(this.dexterity)
				modifier += this.proficiencyBonus;
		}
		else if(saveType == "con")
		{
			modifier = convertScoreToModifier(this.constitutionScore);
			if(this.constitution)
				modifier += this.proficiencyBonus;
		}
		else if(saveType == "int")
		{
			modifier = convertScoreToModifier(this.intelligenceScore);
			if(this.intelligence)
				modifier += this.proficiencyBonus;
		}
		else if(saveType == "wis")
		{
			modifier = convertScoreToModifier(this.wisdomScore);
			if(this.wisdom)
				modifier += this.proficiencyBonus;
		}
		else if(saveType == "cha")
		{
			modifier = convertScoreToModifier(this.charismaScore);
			if(this.charisma)
				modifier += this.proficiencyBonus;
		}
		
		if(modifier > 0)
			resultText = resultText + " + " + modifier.toString();
		else if(modifier < 0)
			resultText = resultText + " " + modifier.toString();
		
		return resultText;
	}
	
	convertAbilityScoreToMod(abScore)
	{
		let mod = Math.floor(abScore / 2) - 5;
	
		return mod;
	}
	
	getMod(scoreName)
	{
		let score = 0;
		
		if(scoreName == "Strength")
			score = this.strengthScore;
		else if(scoreName == "Dexterity")
			score = this.dexterityScore;
		else if(scoreName == "Constitution")
			score = this.constitutionScore;
		else if(scoreName == "Intelligence")
			score = this.intelligenceScore;
		else if(scoreName == "Wisdom")
			score = this.wisdomScore;
		else if(scoreName == "Charisma")
			score = this.charismaScore;
		
		return this.convertAbilityScoreToMod(score);
	}
	
	getIsProf(scoreName)
	{
		let prof = false;
		
		if(scoreName == "Strength")
			prof = this.strength;
		else if(scoreName == "Dexterity")
			prof = this.dexterity;
		else if(scoreName == "Constitution")
			prof = this.constitution;
		else if(scoreName == "Intelligence")
			prof = this.intelligence;
		else if(scoreName == "Wisdom")
			prof = this.wisdom;
		else if(scoreName == "Charisma")
			prof = this.charisma;
		
		return prof;
	}
	
	createRollStringSkillCheck(skillId) {
		let resultText = "/r 1d20";
		let modifier = 0;
		
		for(var i = 0; i < this.skills.length; i++)
		{
			if(skillId == this.skills[i].id)
			{
				modifier = this.getMod(this.skills[i].scoretouse);
				if(this.skills[i].proficient)
					modifier += this.proficiencyBonus;
			}
		}
		
		if(modifier > 0)
			resultText = resultText + " + " + modifier.toString();
		if(modifier < 0)
			resultText = resultText + " " + modifier.toString();
		
		return resultText;
	}
	
	createRollStringAttack(attackId) {
		let attackText = "";
		let damageText = "";
		
		for(var i = 0; i < this.attacks.length; i++)
		{
			if(attackId == this.attacks[i].id)
			{
				attackText = this.attacks[i].attackroll;
				damageText = this.attacks[i].damageroll;
			}
		}
		
		return attackText + "\n" + damageText;
	}
}

/*class Skill {
	constructor(dbInfo){
		this.id = dbInfo["id"];
		this.name = dbInfo["name"];
		this.scoreToUse = dbInfo["scoretouse"].toString();
		this.proficient = dbInfo["proficient"];
	}
}*/

let focusCharacter = null;

let createRollStringSaveThrow = function(focusCharacter, saveType)
{
	let resultText = focusCharacter.createRollStringSaveThrow(saveType);
	
	document.querySelector("#result").innerHTML = resultText;
	
	copyToClipboard(resultText);
}

let createRollStringSkillCheck = function(focusCharacter, skillId)
{
	let resultText = focusCharacter.createRollStringSkillCheck(skillId);
	
	document.querySelector("#result").innerHTML = resultText;
	
	copyToClipboard(resultText);
}

let createRollStringAttack = function(focusCharacter, attackId)
{
	let resultText = focusCharacter.createRollStringAttack(attackId);
	
	document.querySelector("#result").innerHTML = resultText;
	
	copyToClipboard(resultText);
}

let copyToClipboard = function(text) 
{
	window.prompt("Copy to clipboard: Ctrl+C, Enter", text);
}

let convertScoreToModifier = function(score)
{
	let mod = Math.floor(score / 2) - 5;
	
	return mod;
}