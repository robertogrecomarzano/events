var strCodFis = "";
var strcognome = "";
var strnome = "";
var strgiornosex = "";
var chrcontrollo = '';

var campocomune;
var campocognome;
var camponome;
var campodata;
var camposesso;

// Controls/Definitions:
// --------------------------------------------------------------------------
DefaultValues();

// -------------------------
// Setta i valori di default
// -------------------------
function DefaultValues() {
	strCodFis = "";
	strcognome = "";
	strnome = "";
	strgiornosex = "";
	chrcontrollo = '';

	Cognome = "";
	Nome = "";
	Sesso = 0;
	Comune = "";
	CodiceFiscale = "";
	AnnoCento = 19;
	AnnoDieci = "0";
	AnnoZero = "0";
	Mese = "A";
	Giorno = 1;

	return;
}

// --------------------------------------------------------------------------
function CheckCognome(campocognome) {
	if (campocognome.value.length < 1) {
		bootbox.alert("<h3>Calcolo del CF</h3>Manca il Cognome!");
		return (0);
	}
	campocognome.value = campocognome.value.toUpperCase();
	return (1);
}

// --------------------------------------------------------------------------
function CheckNome(camponome) {
	if (camponome.value.length < 1) {
		bootbox.alert("<h3>Calcolo del CF</h3>Manca il Nome!");
		return (0);
	}
	camponome.value = camponome.value.toUpperCase();
	return (1);
}

// --------------------------------------------------------------------------
function CheckComune(campocomune) {
	if (campocomune.value.length < 1) {
		bootbox.alert("<h3>Calcolo del CF</h3>Manca il Comune di nascita!");
		return (0);
	}

	campocomune.value = campocomune.value.toUpperCase();

	return (1);
}

// --------------------------------------------------------------------------
function CheckData(campodata) {
	if (campodata.value.length < 1) {
		bootbox.alert("<h3>Calcolo del CF</h3>Manca la Data di nascita!");
		return (0);
	}
	campodata.value = campodata.value.toUpperCase();
	return (1);
}

// --------------------------------------------------------------------------
function CheckSesso(camposesso) {
	if (getSelectedRadioValue(camposesso) == "") {
		bootbox.alert("<h3>Calcolo del CF</h3>Manca il Sesso!");
		return (0);
	}
	return (1);
}

// -------------------------------- ajax ---------------------------------

// --------------------------------------------------------------------------
function doCodiceFiscale(v_campocognome, v_camponome, v_camposesso, v_campocomune, campocf, v_campodata) {
	campocomune = v_campocomune;
	campocognome = v_campocognome;
	camponome = v_camponome;
	campodata = v_campodata;
	camposesso = v_camposesso;

	var gs = 0;
	var i = 0;
	var somma = 0;

	strCodFis = "";
	strcognome = "";
	strnome = "";
	strgiornosex = "";
	chrcontrollo = '';

	campocf.value = "XXXXXXXXXXXXXXXX";

	if (CheckCognome(campocognome) && CheckNome(camponome)
			&& CheckComune(campocomune) && CheckSesso(camposesso)
			&& CheckData(campodata)) {

		Comune = campocomune.value;

		Giorno = parseInt(campodata.value.substr(0, 2), 10);
		AnnoCento = parseInt(campodata.value.substr(6, 2), 10);
		AnnoDieci = parseInt(campodata.value.substr(8, 1), 10);
		AnnoZero = parseInt(campodata.value.substr(9, 1), 10);

		numeroMese = campodata.value.substr(3, 2);
		switch (numeroMese) {
		case '01':
			Mese = "A";
			break;
		case '02':
			Mese = "B";
			break;
		case '03':
			Mese = "C";
			break;
		case '04':
			Mese = "D";
			break;
		case '05':
			Mese = "E";
			break;
		case '06':
			Mese = "H";
			break;
		case '07':
			Mese = "L";
			break;
		case '08':
			Mese = "M";
			break;
		case '09':
			Mese = "P";
			break;
		case '10':
			Mese = "R";
			break;
		case '11':
			Mese = "S";
			break;
		case '12':
			Mese = "T";
			break;
		}
		sex = getSelectedRadioValue(camposesso);
		switch (sex) {
		case '0':
			Sesso = parseInt(0);
			break;
		case '1':
			Sesso = parseInt(1);
			break;
		}

		// Processa il cognome
		// ----------------------------------------------------------------
		for (i = 0; i < campocognome.value.length; i++) {
			switch (campocognome.value.charAt(i)) {
			case 'A':
			case 'E':
			case 'I':
			case 'O':
			case 'U':
				break;
			default:
				if ((campocognome.value.charAt(i) <= 'Z')
						&& (campocognome.value.charAt(i) > 'A'))
					strcognome = strcognome + campocognome.value.charAt(i);
			}
		}
		if (strcognome.length < 3) {
			for (i = 0; i < campocognome.value.length; i++) {
				switch (campocognome.value.charAt(i)) {
				case 'A':
				case 'E':
				case 'I':
				case 'O':
				case 'U':
					strcognome = strcognome + campocognome.value.charAt(i);
				}
			}
			if (strcognome.length < 3) {
				for (i = strcognome.length; i <= 3; i++) {
					strcognome = strcognome + 'X';
				}
			}
		}
		strcognome = strcognome.substring(0, 3);
		// ------------------------------------------------------------

		// processa il nome
		// ----------------------------------------------------------------
		for (i = 0; i < camponome.value.length; i++) {
			switch (camponome.value.charAt(i)) {
			case 'A':
			case 'E':
			case 'I':
			case 'O':
			case 'U':
				break;
			default:
				if ((camponome.value.charAt(i) <= 'Z')
						&& (camponome.value.charAt(i) > 'A'))
					strnome = strnome + camponome.value.charAt(i);
			}
		}
		if (strnome.length > 3) {
			strnome = strnome.substring(0, 1) + strnome.substring(2, 4);
		} else {
			if (strnome.length < 3) {
				for (i = 0; i < camponome.value.length; i++) {
					switch (camponome.value.charAt(i)) {
					case 'A':
					case 'E':
					case 'I':
					case 'O':
					case 'U':
						strnome = strnome + camponome.value.charAt(i);
					}
				}
				if (strnome.length < 3) {
					for (i = strnome.length; i <= 3; i++) {
						strnome = strnome + 'X';
					}
				}
			}
			strnome = strnome.substring(0, 3);
		}
		// --------------------------------------- Fine processa nome

		// processa giorno e sesso
		// --------------------------------------------
		gs = Giorno + (40 * Sesso);
		if (gs < 10)
			strgiornosex = "0" + gs;
		else
			strgiornosex = gs;
		// --------------------------------------------

		strCodFis = strcognome + strnome + AnnoDieci + AnnoZero + Mese
				+ strgiornosex + Comune;

		// calcola la cifra di controllo
		// --------------------------------------------
		for (i = 0; i < 15; i++) {
			if (((i + 1) % 2) != 0) // caratteri dispari
			{
				switch (strCodFis.charAt(i)) {
				case '0':
				case 'A': {
					somma += 1;
					break;
				}
				case '1':
				case 'B': {
					somma += 0;
					break;
				}
				case '2':
				case 'C': {
					somma += 5;
					break;
				}
				case '3':
				case 'D': {
					somma += 7;
					break;
				}
				case '4':
				case 'E': {
					somma += 9;
					break;
				}
				case '5':
				case 'F': {
					somma += 13;
					break;
				}
				case '6':
				case 'G': {
					somma += 15;
					break;
				}
				case '7':
				case 'H': {
					somma += 17;
					break;
				}
				case '8':
				case 'I': {
					somma += 19;
					break;
				}
				case '9':
				case 'J': {
					somma += 21;
					break;
				}
				case 'K': {
					somma += 2;
					break;
				}
				case 'L': {
					somma += 4;
					break;
				}
				case 'M': {
					somma += 18;
					break;
				}
				case 'N': {
					somma += 20;
					break;
				}
				case 'O': {
					somma += 11;
					break;
				}
				case 'P': {
					somma += 3;
					break;
				}
				case 'Q': {
					somma += 6;
					break;
				}
				case 'R': {
					somma += 8;
					break;
				}
				case 'S': {
					somma += 12;
					break;
				}
				case 'T': {
					somma += 14;
					break;
				}
				case 'U': {
					somma += 16;
					break;
				}
				case 'V': {
					somma += 10;
					break;
				}
				case 'W': {
					somma += 22;
					break;
				}
				case 'X': {
					somma += 25;
					break;
				}
				case 'Y': {
					somma += 24;
					break;
				}
				case 'Z': {
					somma += 23;
					break;
				}
				}
			} else // caratteri pari
			{
				switch (strCodFis.charAt(i)) {
				case '0':
				case 'A': {
					somma += 0;
					break;
				}
				case '1':
				case 'B': {
					somma += 1;
					break;
				}
				case '2':
				case 'C': {
					somma += 2;
					break;
				}
				case '3':
				case 'D': {
					somma += 3;
					break;
				}
				case '4':
				case 'E': {
					somma += 4;
					break;
				}
				case '5':
				case 'F': {
					somma += 5;
					break;
				}
				case '6':
				case 'G': {
					somma += 6;
					break;
				}
				case '7':
				case 'H': {
					somma += 7;
					break;
				}
				case '8':
				case 'I': {
					somma += 8;
					break;
				}
				case '9':
				case 'J': {
					somma += 9;
					break;
				}
				case 'K': {
					somma += 10;
					break;
				}
				case 'L': {
					somma += 11;
					break;
				}
				case 'M': {
					somma += 12;
					break;
				}
				case 'N': {
					somma += 13;
					break;
				}
				case 'O': {
					somma += 14;
					break;
				}
				case 'P': {
					somma += 15;
					break;
				}
				case 'Q': {
					somma += 16;
					break;
				}
				case 'R': {
					somma += 17;
					break;
				}
				case 'S': {
					somma += 18;
					break;
				}
				case 'T': {
					somma += 19;
					break;
				}
				case 'U': {
					somma += 20;
					break;
				}
				case 'V': {
					somma += 21;
					break;
				}
				case 'W': {
					somma += 22;
					break;
				}
				case 'X': {
					somma += 23;
					break;
				}
				case 'Y': {
					somma += 24;
					break;
				}
				case 'Z': {
					somma += 25;
					break;
				}
				}
			}
		}
		somma %= 26;
		switch (somma) {
		case 0: {
			chrcontrollo = 'A';
			break;
		}
		case 1: {
			chrcontrollo = 'B';
			break;
		}
		case 2: {
			chrcontrollo = 'C';
			break;
		}
		case 3: {
			chrcontrollo = 'D';
			break;
		}
		case 4: {
			chrcontrollo = 'E';
			break;
		}
		case 5: {
			chrcontrollo = 'F';
			break;
		}
		case 6: {
			chrcontrollo = 'G';
			break;
		}
		case 7: {
			chrcontrollo = 'H';
			break;
		}
		case 8: {
			chrcontrollo = 'I';
			break;
		}
		case 9: {
			chrcontrollo = 'J';
			break;
		}
		case 10: {
			chrcontrollo = 'K';
			break;
		}
		case 11: {
			chrcontrollo = 'L';
			break;
		}
		case 12: {
			chrcontrollo = 'M';
			break;
		}
		case 13: {
			chrcontrollo = 'N';
			break;
		}
		case 14: {
			chrcontrollo = 'O';
			break;
		}
		case 15: {
			chrcontrollo = 'P';
			break;
		}
		case 16: {
			chrcontrollo = 'Q';
			break;
		}
		case 17: {
			chrcontrollo = 'R';
			break;
		}
		case 18: {
			chrcontrollo = 'S';
			break;
		}
		case 19: {
			chrcontrollo = 'T';
			break;
		}
		case 20: {
			chrcontrollo = 'U';
			break;
		}
		case 21: {
			chrcontrollo = 'V';
			break;
		}
		case 22: {
			chrcontrollo = 'W';
			break;
		}
		case 23: {
			chrcontrollo = 'X';
			break;
		}
		case 24: {
			chrcontrollo = 'Y';
			break;
		}
		case 25: {
			chrcontrollo = 'Z';
			break;
		}
		}
		// --------------------------------------------

		campocf.value = strcognome + strnome + AnnoDieci + AnnoZero + Mese
				+ strgiornosex + Comune + chrcontrollo;

		if ((campocf.value.length < 16))
			campocf.value = "XXXXXXXXXXXXXXXX";

	}
	return;
}

function getSelectedRadio(buttonGroup) {
	// returns the array number of the selected radio button or -1 if no button
	// is selected
	if (buttonGroup[0]) { // if the button group is an array (one button is
							// not an array)
		for ( var i = 0; i < buttonGroup.length; i++) {
			if (buttonGroup[i].checked) {
				return i
			}
		}
	} else {
		if (buttonGroup.checked) {
			return 0;
		} // if the one button is checked, return zero
	}
	// if we get to this point, no radio button is selected
	return -1;
} // Ends the "getSelectedRadio" function

function getSelectedRadioValue(buttonGroup) {
	// returns the value of the selected radio button or "" if no button is
	// selected
	var i = getSelectedRadio(buttonGroup);
	if (i == -1) {
		return "";
	} else {
		if (buttonGroup[i]) { // Make sure the button group is an array (not
								// just one button)
			return buttonGroup[i].value;
		} else { // The button group is just the one button, and it is
					// checked
			return buttonGroup.value;
		}
	}
} // Ends the "getSelectedRadioValue" functio

// --------------------------------------------------------------------------
// END OF SCRIPT
// --------------------------------------------------------------------------
