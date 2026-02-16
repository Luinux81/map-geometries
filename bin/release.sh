#!/bin/bash

# Script de release automatizado
# Uso: ./bin/release.sh [major|minor|patch]

set -e

# Colores
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Verificar argumentos
if [ $# -eq 0 ]; then
    echo -e "${RED}Error: Especifica el tipo de release [major|minor|patch]${NC}"
    echo "Uso: $0 [major|minor|patch]"
    exit 1
fi

RELEASE_TYPE=$1

# Verificar que estamos en main
CURRENT_BRANCH=$(git branch --show-current)
if [ "$CURRENT_BRANCH" != "main" ]; then
    echo -e "${RED}Error: Debes estar en la rama 'main' para crear un release${NC}"
    exit 1
fi

# Verificar que no hay cambios sin commitear
if [ -n "$(git status --porcelain)" ]; then
    echo -e "${RED}Error: Hay cambios sin commitear${NC}"
    exit 1
fi

# Obtener la última versión
LAST_TAG=$(git describe --tags --abbrev=0 2>/dev/null || echo "v0.0.0")
echo -e "${YELLOW}Última versión: ${LAST_TAG}${NC}"

# Extraer números de versión
VERSION=${LAST_TAG#v}
MAJOR=$(echo $VERSION | cut -d. -f1)
MINOR=$(echo $VERSION | cut -d. -f2)
PATCH=$(echo $VERSION | cut -d. -f3)

# Incrementar versión según tipo
case $RELEASE_TYPE in
    major)
        MAJOR=$((MAJOR + 1))
        MINOR=0
        PATCH=0
        ;;
    minor)
        MINOR=$((MINOR + 1))
        PATCH=0
        ;;
    patch)
        PATCH=$((PATCH + 1))
        ;;
    *)
        echo -e "${RED}Error: Tipo de release inválido. Usa: major, minor o patch${NC}"
        exit 1
        ;;
esac

NEW_VERSION="$MAJOR.$MINOR.$PATCH"
NEW_TAG="v$NEW_VERSION"

echo -e "${GREEN}Nueva versión: ${NEW_TAG}${NC}"

# Confirmar
read -p "¿Continuar con el release ${NEW_TAG}? (y/n) " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo "Release cancelado"
    exit 1
fi

# Ejecutar tests
echo -e "${YELLOW}Ejecutando tests...${NC}"
composer test

# Crear tag
echo -e "${YELLOW}Creando tag ${NEW_TAG}...${NC}"
git tag -a "$NEW_TAG" -m "Release $NEW_TAG"

# Push tag
echo -e "${YELLOW}Pusheando tag...${NC}"
git push origin "$NEW_TAG"

echo -e "${GREEN}✓ Release ${NEW_TAG} creado exitosamente!${NC}"
echo -e "${GREEN}  GitHub Actions creará automáticamente el release.${NC}"
