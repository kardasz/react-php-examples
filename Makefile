BUILD_NAME ?= kardasz/react-php

.PHONY: image
.DEFAULT: image

image:
	docker build -t "$(BUILD_NAME)" $(CURDIR)/.

bash:
	docker run -it  -v "$(CURDIR):/var/www" -w /var/www "$(BUILD_NAME)" bash
