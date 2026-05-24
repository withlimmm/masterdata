import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const setupRevealAnimations = () => {
	const revealItems = document.querySelectorAll('[data-aos]');

	if (!revealItems.length) {
		return;
	}

	const observer = new IntersectionObserver((entries) => {
		entries.forEach((entry) => {
			if (!entry.isIntersecting) {
				return;
			}

			const element = entry.target;
			const delay = element.getAttribute('data-aos-delay') ?? '0';

			element.style.setProperty('--reveal-delay', `${delay}ms`);
			element.classList.add('is-visible');
			observer.unobserve(element);
		});
	}, {
		threshold: 0.15,
		rootMargin: '0px 0px -8% 0px',
	});

	revealItems.forEach((element) => observer.observe(element));
};

const setupMobileMenu = () => {
	const toggle = document.querySelector('[data-mobile-nav-toggle]');
	const panel = document.querySelector('[data-mobile-nav-panel]');
	const closeButton = document.querySelector('[data-mobile-nav-close]');

	if (!toggle || !panel) {
		return;
	}

	const closePanel = () => {
		panel.classList.add('hidden');
		toggle.setAttribute('aria-expanded', 'false');
	};

	const openPanel = () => {
		panel.classList.remove('hidden');
		toggle.setAttribute('aria-expanded', 'true');
	};

	toggle.addEventListener('click', () => {
		if (panel.classList.contains('hidden')) {
			openPanel();
		} else {
			closePanel();
		}
	});

	if (closeButton) {
		closeButton.addEventListener('click', closePanel);
	}

	panel.querySelectorAll('a').forEach((link) => {
		link.addEventListener('click', closePanel);
	});

	document.addEventListener('click', (event) => {
		if (panel.classList.contains('hidden')) {
			return;
		}

		if (panel.contains(event.target) || toggle.contains(event.target)) {
			return;
		}

		closePanel();
	});
};

const setupStickyNavState = () => {
	const nav = document.querySelector('nav');

	if (!nav) {
		return;
	}

	const updateState = () => {
		nav.dataset.scrolled = window.scrollY > 20 ? 'true' : 'false';
	};

	updateState();
	window.addEventListener('scroll', updateState, { passive: true });
};

const setupHeroParallax = () => {
	const hero = document.querySelector('[data-hero-parallax]');

	if (!hero) {
		return;
	}

	window.addEventListener('mousemove', (event) => {
		const rect = hero.getBoundingClientRect();
		const isInViewport = rect.top < window.innerHeight && rect.bottom > 0;

		if (!isInViewport) {
			return;
		}

		const x = (event.clientX / window.innerWidth - 0.5) * 14;
		const y = (event.clientY / window.innerHeight - 0.5) * 14;

		hero.style.setProperty('--hero-shift-x', `${x}px`);
		hero.style.setProperty('--hero-shift-y', `${y}px`);
	});
};

const setupSelectableCards = () => {
	const cards = document.querySelectorAll('[data-selectable-card]');

	if (!cards.length) {
		return;
	}

	const setActiveCard = (selectedCard) => {
		cards.forEach((card) => {
			card.setAttribute('aria-pressed', card === selectedCard ? 'true' : 'false');
		});
	};

	cards.forEach((card, index) => {
		card.addEventListener('click', () => setActiveCard(card));

		if (index === 0) {
			card.setAttribute('aria-pressed', 'true');
		}
	});
};

const setupWhatsAppLauncher = () => {
	const launcher = document.querySelector('[data-whatsapp-fab]');
	const cards = document.querySelectorAll('[data-whatsapp-message]');

	if (!launcher || !cards.length) {
		return;
	}

	const phoneNumber = launcher.getAttribute('data-whatsapp-number') || '6287868184742';
	const defaultMessage = launcher.getAttribute('data-whatsapp-default-message') || 'Halo, saya ingin konsultasi layanan digital.';

	const applyMessage = (message) => {
		launcher.setAttribute('href', `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`);
	};

	applyMessage(defaultMessage);

	cards.forEach((card) => {
		card.addEventListener('click', () => {
			const message = card.getAttribute('data-whatsapp-message') || defaultMessage;
			applyMessage(message);
		});
	});
};

document.addEventListener('DOMContentLoaded', () => {
	setupRevealAnimations();
	setupMobileMenu();
	setupStickyNavState();
	setupHeroParallax();
	setupSelectableCards();
	setupWhatsAppLauncher();
});