<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output indent='no' method="html" />
	<xsl:strip-space elements="*" />

	<xsl:template match='/'>
		<ul>
			<xsl:for-each select="//node">
				<xsl:if test="descendant-or-self::node[@id=$id]">
					<li>
						<a>
							<xsl:attribute name="href">
             			       <xsl:value-of select="@url" />
              				</xsl:attribute>
							<xsl:value-of select="label/text()" />
						</a>
					</li>
				</xsl:if>
			</xsl:for-each>
		</ul>
	</xsl:template>

</xsl:stylesheet>   

