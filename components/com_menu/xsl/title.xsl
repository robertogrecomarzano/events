<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output indent='no' method="html" />
	<xsl:strip-space elements="*" />

	<xsl:template match='/'>
		<xsl:for-each select="//node">
			<xsl:if test="descendant-or-self::node[@id=$id]">
				<xsl:value-of select="label/text()" />
				<xsl:if test="not(@id=$id)">
					<xsl:text> - </xsl:text>
				</xsl:if>
			</xsl:if>
		</xsl:for-each>
	</xsl:template>

</xsl:stylesheet>