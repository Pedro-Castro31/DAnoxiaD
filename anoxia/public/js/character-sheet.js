(() => {
	'use strict';

	const mainLogo = document.getElementById('mainLogo');
	const logoFallback = document.getElementById('logoFallback');
	if (mainLogo && logoFallback) {
		mainLogo.addEventListener('error', () => {
			mainLogo.classList.add('hidden');
			logoFallback.classList.remove('hidden');
			logoFallback.classList.add('inline-flex');
		});
	}

	const openBtn = document.getElementById('mobileMenuButton');
	const closeBtn = document.getElementById('mobileMenuClose');
	const offcanvas = document.getElementById('mobileOffcanvas');
	const backdrop = document.getElementById('mobileBackdrop');

	if (openBtn && closeBtn && offcanvas && backdrop) {
		const openNav = () => {
			offcanvas.classList.remove('translate-x-full', 'pointer-events-none');
			backdrop.classList.remove('hidden');
			document.body.classList.add('overflow-hidden');
		};

		const closeNav = () => {
			offcanvas.classList.add('translate-x-full', 'pointer-events-none');
			backdrop.classList.add('hidden');
			document.body.classList.remove('overflow-hidden');
		};

		openBtn.addEventListener('click', openNav);
		closeBtn.addEventListener('click', closeNav);
		backdrop.addEventListener('click', closeNav);
		document.addEventListener('keydown', (event) => {
			if (event.key === 'Escape') {
				closeNav();
			}
		});
	}

	const avatarBtn = document.getElementById('avatarMenuButton');
	const avatarMenu = document.getElementById('avatarDropdown');

	if (avatarBtn && avatarMenu) {
		avatarBtn.addEventListener('click', (event) => {
			event.stopPropagation();
			const hidden = avatarMenu.classList.contains('hidden');
			avatarMenu.classList.toggle('hidden', !hidden);
			avatarBtn.setAttribute('aria-expanded', String(hidden));
		});

		document.addEventListener('click', (event) => {
			if (!avatarMenu.contains(event.target) && !avatarBtn.contains(event.target)) {
				avatarMenu.classList.add('hidden');
				avatarBtn.setAttribute('aria-expanded', 'false');
			}
		});
	}

	function initToggles(context) {
		(context || document).querySelectorAll('.toggle-circ').forEach((button) => {
			if (button.dataset.initDone) {
				return;
			}

			button.dataset.initDone = '1';
			button.addEventListener('click', () => button.classList.toggle('is-active'));
		});
	}

	initToggles();

	const profSlider = document.getElementById('profSlider');
	const charSlider = document.getElementById('charSlider');
	const sliderHandle = document.getElementById('sliderHandle');
	const sliderBackdrop = document.getElementById('sliderBackdrop');
	const sliderButtons = document.querySelectorAll('[data-action="toggle-prof-slider"]');
	const charSliderButtons = document.querySelectorAll('[data-action="toggle-char-slider"]');

	function setBackdropState() {
		const isOpen = profSlider.classList.contains('slider-open') || charSlider.classList.contains('slider-open');
		sliderBackdrop.classList.toggle('active', isOpen);
	}

	function closeProfSlider() {
		profSlider.classList.remove('slider-open');
		sliderHandle.classList.remove('slider-open');
		setBackdropState();
	}

	function closeCharSlider() {
		charSlider.classList.remove('slider-open');
		setBackdropState();
	}

	function openProfSlider() {
		closeCharSlider();
		profSlider.classList.add('slider-open');
		sliderHandle.classList.add('slider-open');
		setBackdropState();
	}

	function openCharSlider() {
		closeProfSlider();
		charSlider.classList.add('slider-open');
		setBackdropState();
	}

	if (profSlider && charSlider && sliderHandle && sliderBackdrop) {
		sliderButtons.forEach((button) => {
			button.addEventListener('click', () => {
				if (profSlider.classList.contains('slider-open')) {
					closeProfSlider();
					return;
				}

				openProfSlider();
			});
		});

		charSliderButtons.forEach((button) => {
			button.addEventListener('click', () => {
				if (charSlider.classList.contains('slider-open')) {
					closeCharSlider();
					return;
				}

				openCharSlider();
			});
		});

		sliderBackdrop.addEventListener('click', () => {
			closeProfSlider();
			closeCharSlider();
		});

		let touchStartX = 0;
		const contentWrapper = profSlider.parentElement;

		contentWrapper.addEventListener('touchstart', (event) => {
			touchStartX = event.changedTouches[0].clientX;
		}, { passive: true });

		contentWrapper.addEventListener('touchend', (event) => {
			const deltaX = event.changedTouches[0].clientX - touchStartX;

			if (deltaX > 50) {
				if (charSlider.classList.contains('slider-open')) {
					closeCharSlider();
					return;
				}

				if (!profSlider.classList.contains('slider-open')) {
					openProfSlider();
				}

				return;
			}

			if (deltaX < -50) {
				if (profSlider.classList.contains('slider-open')) {
					closeProfSlider();
					return;
				}

				if (!charSlider.classList.contains('slider-open')) {
					openCharSlider();
				}
			}
		}, { passive: true });
	}

	function makeDeleteButton(row, onDelete) {
		const cell = document.createElement('td');
		cell.className = 'text-center';

		const button = document.createElement('button');
		button.type = 'button';
		button.title = 'Remover linha';
		button.className = 'inline-flex h-5 w-5 items-center justify-center rounded-full border border-[#b66b5a] bg-[#51241d] text-[#f6ccc3] text-[10px] hover:bg-[#6b2e26] transition';
		button.innerHTML = '<i class="ri-close-line" aria-hidden="true"></i>';
		button.addEventListener('click', () => {
			if (typeof onDelete === 'function') {
				onDelete();
				return;
			}

			row.remove();
		});

		cell.appendChild(button);
		return cell;
	}

	function autoResize(textarea) {
		textarea.style.height = 'auto';
		textarea.style.height = `${textarea.scrollHeight}px`;
	}

	function addNameDescRow(options) {
		const tbody = document.getElementById(options.tbodyId);
		if (!tbody) {
			return;
		}

		const row = document.createElement('tr');

		const nameCell = document.createElement('td');
		const nameInput = document.createElement('input');
		nameInput.type = 'text';
		nameInput.placeholder = options.namePlaceholder;
		nameInput.className = 'sheet-input';
		nameInput.setAttribute('aria-label', options.nameAriaLabel);
		nameCell.appendChild(nameInput);
		row.appendChild(nameCell);

		const descriptionCell = document.createElement('td');
		const textarea = document.createElement('textarea');
		textarea.placeholder = options.descriptionPlaceholder;
		textarea.rows = 1;
		textarea.className = 'sheet-input auto-textarea';
		textarea.setAttribute('aria-label', options.descriptionAriaLabel);
		textarea.addEventListener('input', () => autoResize(textarea));
		descriptionCell.appendChild(textarea);
		row.appendChild(descriptionCell);

		row.appendChild(makeDeleteButton(row));
		tbody.appendChild(row);
	}

	function addAttackRow() {
		const tbody = document.getElementById('attacksBody');
		if (!tbody) {
			return;
		}

		const row = document.createElement('tr');
		const fields = [
			{ placeholder: 'Sword', label: 'Nome do ataque' },
			{ placeholder: '+5', label: 'Attack bonus' },
			{ placeholder: '1d8+3 slash.', label: 'Damage and type' },
		];

		fields.forEach(({ placeholder, label }) => {
			const cell = document.createElement('td');
			const input = document.createElement('input');
			input.type = 'text';
			input.placeholder = placeholder;
			input.className = 'sheet-input';
			input.setAttribute('aria-label', label);
			cell.appendChild(input);
			row.appendChild(cell);
		});

		row.appendChild(makeDeleteButton(row));
		tbody.appendChild(row);
	}

	function addSpellRow() {
		const tbody = document.getElementById('spellsBody');
		if (!tbody) {
			return;
		}

		const row = document.createElement('tr');
		const descriptionRow = document.createElement('tr');
		const descriptionCell = document.createElement('td');
		descriptionCell.colSpan = 3;

		const textarea = document.createElement('textarea');
		textarea.placeholder = 'Descrição…';
		textarea.rows = 1;
		textarea.className = 'sheet-input auto-textarea';
		textarea.setAttribute('aria-label', 'Spell description');
		textarea.addEventListener('input', () => autoResize(textarea));
		descriptionCell.appendChild(textarea);
		descriptionRow.appendChild(descriptionCell);

		const nameCell = document.createElement('td');
		const nameInput = document.createElement('input');
		nameInput.type = 'text';
		nameInput.placeholder = 'Fireball';
		nameInput.className = 'sheet-input';
		nameInput.setAttribute('aria-label', 'Spell name');
		nameCell.appendChild(nameInput);
		row.appendChild(nameCell);

		const levelCell = document.createElement('td');
		const levelInput = document.createElement('input');
		levelInput.type = 'number';
		levelInput.min = '0';
		levelInput.max = '9';
		levelInput.placeholder = '3';
		levelInput.className = 'sm-input';
		levelInput.setAttribute('aria-label', 'Spell level');
		levelCell.appendChild(levelInput);
		row.appendChild(levelCell);

		row.appendChild(makeDeleteButton(row, () => {
			descriptionRow.remove();
			row.remove();
		}));

		tbody.appendChild(row);
		tbody.appendChild(descriptionRow);
	}

	function addEquipRow() {
		addNameDescRow({
			tbodyId: 'equipBody',
			namePlaceholder: 'Longsword',
			nameAriaLabel: 'Item name',
			descriptionPlaceholder: 'Descrição ou notas…',
			descriptionAriaLabel: 'Item description',
		});
	}

	function addFeatureTraitRow() {
		addNameDescRow({
			tbodyId: 'featuresTraitsBody',
			namePlaceholder: 'Darkvision',
			nameAriaLabel: 'Feature or trait name',
			descriptionPlaceholder: 'Descrição da feature ou trait…',
			descriptionAriaLabel: 'Feature or trait description',
		});
	}

	function addOtherProficiencyRow() {
		addNameDescRow({
			tbodyId: 'otherProficienciesBody',
			namePlaceholder: 'Elvish',
			nameAriaLabel: 'Other proficiency or language name',
			descriptionPlaceholder: 'Descrição da proficiência ou idioma…',
			descriptionAriaLabel: 'Other proficiency or language description',
		});
	}

	const addRowHandlers = {
		attack: addAttackRow,
		spell: addSpellRow,
		equipment: addEquipRow,
		'feature-trait': addFeatureTraitRow,
		'other-proficiency': addOtherProficiencyRow,
	};

	document.querySelectorAll('[data-add-row]').forEach((button) => {
		button.addEventListener('click', () => {
			const type = button.dataset.addRow;
			const handler = addRowHandlers[type];

			if (typeof handler === 'function') {
				handler();
			}
		});
	});
})();
